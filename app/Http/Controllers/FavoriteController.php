<?php
namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success'       => false,
                'require_login' => true,
                'message'       => 'Login terlebih dahulu untuk menyimpan favorit.',
            ], 401);
        }

        $request->validate(['slug' => 'required|string']);
        $slug = $request->slug;

        // Cek dulu apakah sudah jadi favorit
        $existing = Favorite::where('user_id', Auth::id())
                            ->where('product_slug', $slug)
                            ->first();

        if ($existing) {
            $existing->delete();
            $count = Favorite::where('user_id', Auth::id())->count();
            return response()->json([
                'success'     => true,
                'is_favorite' => false,
                'count'       => $count,
            ]);
        }

        // Ambil produk hanya jika perlu create — reuse cache product jika ada
        $product = Product::where('slug', $slug)->with('brand:id,name')->first();

        $rawImage = $product?->image ?? '';
        if ($rawImage && !str_starts_with($rawImage, 'images/') && !str_starts_with($rawImage, 'storage/')) {
            $resolvedImage = 'storage/' . ltrim($rawImage, '/');
        } else {
            $resolvedImage = $rawImage ?: 'images/products/california-signature.png';
        }

        Favorite::create([
            'user_id'       => Auth::id(),
            'product_slug'  => $slug,
            'product_name'  => $product?->name ?? $slug,
            'product_brand' => $product?->brand?->name ?? '',
            'product_image' => $resolvedImage,
        ]);

        $count = Favorite::where('user_id', Auth::id())->count();
        return response()->json([
            'success'     => true,
            'is_favorite' => true,
            'count'       => $count,
        ]);
    }

    public function index()
    {
        if (!Auth::check()) return redirect()->route('login');

        $favorites = Favorite::where('user_id', Auth::id())
                             ->latest()
                             ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function destroy(string $slug)
    {
        if (!Auth::check()) return redirect()->route('login');

        Favorite::where('user_id', Auth::id())
                ->where('product_slug', $slug)
                ->delete();

        return back()->with('success', 'Dihapus dari favorit.');
    }

    public function status(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['is_favorite' => false, 'count' => 0]);
        }

        $userId = Auth::id();
        $slug   = $request->query('slug');

        // Ambil KEDUANYA dalam 1 round ke DB: count + is_favorite
        $favs = Favorite::where('user_id', $userId)
            ->selectRaw('COUNT(*) as total, SUM(product_slug = ?) as matched', [$slug])
            ->first();

        return response()->json([
            'is_favorite' => (bool) ($favs->matched ?? 0),
            'count'       => (int)  ($favs->total   ?? 0),
        ]);
    }
}
