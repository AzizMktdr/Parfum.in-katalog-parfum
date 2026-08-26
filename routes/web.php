<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\AccordController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\FragranceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\FollowController;

/* ── Public routes ── */
Route::get('/',              [HomeController::class,    'index'])        ->name('home');
Route::get('/fragrances',    [FragranceController::class,'index'])       ->name('fragrances.index');
Route::get('/product/{slug}',[ProductController::class, 'show'])         ->name('product.detail');
Route::get('/brands',        [BrandController::class,   'index'])        ->name('brands.index');
Route::get('/brands/{slug}', [BrandController::class,   'show'])         ->name('brands.show');
Route::get('/accords',       [AccordController::class,  'index'])        ->name('accords.index');
Route::get('/accords/{slug}',[AccordController::class,  'show'])         ->name('accords.show');
Route::get('/notes',         [NoteController::class,    'index'])        ->name('notes.index');

/* ── Auth ── */
Route::get ('/login',    [AuthController::class,'showLogin'])   ->name('login')         ->middleware('guest');
Route::post('/login',    [AuthController::class,'login'])        ->name('login.post')    ->middleware(['guest', 'throttle:5,1']);
Route::get ('/register', [AuthController::class,'showRegister'])->name('register')      ->middleware('guest');
Route::post('/register', [AuthController::class,'register'])     ->name('register.post')->middleware(['guest', 'throttle:5,1']);
Route::post('/logout',   [AuthController::class,'logout'])       ->name('logout')        ->middleware('auth');

/* ── Password Reset ── */
Route::middleware('guest')->group(function () {
    Route::get ('/forgot-password',        [PasswordResetController::class,'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password',        [PasswordResetController::class,'sendResetLink'])      ->name('password.email')  ->middleware('throttle:5,1');
    Route::get ('/reset-password/{token}', [PasswordResetController::class,'showResetForm'])      ->name('password.reset');
    Route::post('/reset-password',         [PasswordResetController::class,'resetPassword'])      ->name('password.update') ->middleware('throttle:5,1');
});

/* ── Pengaturan akun (pemilik akun) ── */
Route::middleware('auth')->group(function () {
    Route::get  ('/profile',          [ProfileController::class,'edit'])          ->name('profile.edit');
    Route::patch('/profile',          [ProfileController::class,'update'])        ->name('profile.update')         ->middleware('throttle:20,1');
    Route::put  ('/profile/password', [ProfileController::class,'updatePassword'])->name('profile.password.update')->middleware('throttle:6,1');
});

/* ── Reviews ── */
Route::get ('/product/{slug}/reviews', [ReviewController::class,'index'])->name('reviews.index')->middleware('throttle:60,1');
Route::post('/product/{slug}/review',  [ReviewController::class,'store'])->name('review.store')->middleware('throttle:10,1');

/* ── Favorites ── */
Route::get   ('/favorites',             [FavoriteController::class,'index'])  ->name('favorites.index')  ->middleware('auth');
Route::post  ('/favorites/toggle',      [FavoriteController::class,'toggle']) ->name('favorites.toggle')  ->middleware('throttle:30,1');
Route::delete('/favorites/{slug}',      [FavoriteController::class,'destroy'])->name('favorites.destroy')->middleware('auth');
Route::get   ('/favorites/status',      [FavoriteController::class,'status']) ->name('favorites.status')  ->middleware('throttle:60,1');

/* ── Community & Diskusi ── */
Route::get('/community',               [CommunityController::class, 'feed'])->name('community');
Route::get('/discussions/{discussion}',[DiscussionController::class,'show'])->name('discussion.show');

Route::middleware('auth')->group(function () {
    Route::post  ('/discussions',                    [DiscussionController::class,'store'])       ->name('discussion.store')        ->middleware('throttle:10,1');
    Route::post  ('/discussions/{discussion}/reply', [DiscussionController::class,'reply'])       ->name('discussion.reply')        ->middleware('throttle:20,1');
    Route::post  ('/discussions/{discussion}/like',  [DiscussionController::class,'like'])        ->name('discussion.like')         ->middleware('throttle:60,1');
    Route::delete('/discussions/{discussion}',       [DiscussionController::class,'destroy'])     ->name('discussion.destroy');
    Route::delete('/discussion-replies/{reply}',     [DiscussionController::class,'destroyReply'])->name('discussion.reply.destroy');
});

/* ── Koleksi ──
   Urutan penting: rute statis (/community, /create) harus didaftarkan
   sebelum rute dinamis /collections/{collection}. */
Route::get('/collections/community', [CollectionController::class,'community'])->name('collections.community');

Route::middleware('auth')->group(function () {
    Route::get ('/collections',        [CollectionController::class,'myCollections'])->name('collections.index');
    Route::get ('/collections/create', [CollectionController::class,'create'])       ->name('collections.create');
    Route::post('/collections',        [CollectionController::class,'store'])        ->name('collections.store')->middleware('throttle:10,1');
});

Route::get('/collections/{collection}', [CollectionController::class,'show'])->name('collections.show');

Route::middleware('auth')->group(function () {
    Route::post  ('/collections/{collection}/items', [CollectionController::class,'toggleItem'])->name('collections.items.toggle')->middleware('throttle:60,1');
    Route::post  ('/collections/{collection}/like',  [CollectionController::class,'toggleLike'])->name('collections.like')        ->middleware('throttle:60,1');
    Route::delete('/collections/{collection}',       [CollectionController::class,'destroy'])   ->name('collections.destroy');
});

/* ── Profil publik & Follow ── */
Route::get('/u/{username}',           [ProfileController::class,'show'])     ->name('profile.show');
Route::get('/u/{username}/followers', [FollowController::class,'followers'])  ->name('profile.followers');
Route::get('/u/{username}/following', [FollowController::class,'following'])  ->name('profile.following');
Route::post('/u/{user}/follow',       [FollowController::class,'toggle'])     ->name('follow.toggle')->middleware(['auth', 'throttle:30,1']);

/* ── Search API ── */
Route::get('/api/search-products', function () {
    $products = \App\Models\Product::where('is_active', true)
        ->with('brand')
        ->select('name', 'slug', 'image', 'brand_id')
        ->get()
        ->map(function ($p) {
            $image = $p->image
                ? (str_starts_with($p->image, 'images/') ? asset($p->image) : asset('storage/' . ltrim($p->image, '/')))
                : asset('images/products/california-signature.png');
            return [
                'name'  => $p->name,
                'brand' => $p->brand?->name ?? '',
                'slug'  => $p->slug,
                'image' => $image,
            ];
        });
    return response()->json($products);
})->middleware('throttle:60,1')->name('api.search-products');
