<?php
namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\CollectionItem;
use App\Models\CollectionLike;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    // Detail koleksi publik
    public function show(Collection $collection)
    {
        if (!$collection->is_public && $collection->user_id !== Auth::id()) {
            abort(403);
        }

        // ✅ EAGER LOADING: product.brand dimuat sekaligus, bukan per-item
        $items = $collection->items()
            ->with('product.brand')
            ->get();

        $isLiked = $collection->isLikedBy(Auth::user());

        return view('collections.show', compact('collection', 'items', 'isLiked'));
    }

    // Form buat koleksi baru
    public function create()
    {
        return view('collections.create');
    }

    // Simpan koleksi baru
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:300',
            'is_public'   => 'boolean',
            'products'    => 'nullable|array',
            'products.*'  => 'string|exists:products,slug',
        ]);

        $collection = Collection::create([
            'user_id'     => Auth::id(),
            'name'        => $request->name,
            'description' => $request->description,
            'is_public'   => $request->boolean('is_public', true),
        ]);

        // ✅ CHUNKING: gunakan chunk() saat menyimpan banyak produk sekaligus
        if ($request->filled('products')) {
            collect($request->products)->chunk(100)->each(function ($slugChunk) use ($collection) {
                $rows = $slugChunk->map(fn($slug) => [
                    'collection_id' => $collection->id,
                    'product_slug'  => $slug,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ])->toArray();

                CollectionItem::insert($rows);
            });
        }

        return redirect()->route('collections.show', $collection)
            ->with('success', 'Koleksi berhasil dibuat!');
    }

    // Tambah/hapus produk dari koleksi (toggle)
    public function toggleItem(Request $request, Collection $collection)
    {
        if ($collection->user_id !== Auth::id()) abort(403);

        $slug = $request->product_slug;
        $existing = CollectionItem::where('collection_id', $collection->id)
            ->where('product_slug', $slug)
            ->first();

        if ($existing) {
            $existing->delete();
            $added = false;
        } else {
            CollectionItem::create([
                'collection_id' => $collection->id,
                'product_slug'  => $slug,
            ]);
            $added = true;
        }

        return response()->json([
            'added' => $added,
            'count' => $collection->items()->count(),
        ]);
    }

    // Like / unlike koleksi
    public function toggleLike(Collection $collection)
    {
        $existing = CollectionLike::where('user_id', Auth::id())
            ->where('collection_id', $collection->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            CollectionLike::create([
                'user_id'       => Auth::id(),
                'collection_id' => $collection->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $collection->likes()->count(),
        ]);
    }

    // Hapus koleksi
    public function destroy(Collection $collection)
    {
        if ($collection->user_id !== Auth::id()) abort(403);
        $collection->delete();

        return redirect()->route('profile.show', Auth::user()->username ?? Auth::id())
            ->with('success', 'Koleksi dihapus.');
    }

    // List koleksi user — untuk halaman "Koleksi Saya"
    public function myCollections()
    {
        // ✅ CHUNKING: jika user punya banyak koleksi, lazy() cegah OOM
        // ✅ EAGER LOADING: items + product dimuat sekaligus supaya view tidak
        //    menjalankan query per kartu koleksi (N+1).
        $collections = Auth::user()
            ->collections()
            ->withCount('items', 'likes')
            ->with(['items' => fn($q) => $q->with('product:id,slug,name,image')])
            ->latest()
            ->get();

        return view('collections.index', compact('collections'));
    }

    public function community()
    {
        // ✅ EAGER LOADING: user + items.product dimuat sekaligus
        $collections = Collection::where('is_public', true)
            ->with(['user:id,name,username,avatar', 'items.product:slug,name,image'])
            ->withCount(['items', 'likes'])
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('collections.community', compact('collections'));
    }
}
