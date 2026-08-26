<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        // Cache produk detail 30 menit (di-invalidate oleh ProductObserver saat save/delete)
        $product = Cache::remember("product.{$slug}", 1800, function () use ($slug) {
            return Product::where('slug', $slug)
                // ✅ EAGER LOADING: semua relasi yang dipakai view dimuat sekaligus.
                //    'reviews.user' mencegah N+1 (1 query user per review) di daftar review.
                ->with([
                    'brand:id,name,slug,logo',
                    'topNotes',
                    'middleNotes',
                    'baseNotes',
                    'accords',
                    'reviews' => fn($q) => $q->with('user:id,name')->latest(),
                ])
                ->withCount('reviews')
                ->firstOrFail();
        });

        // Related products — cache per brand_id
        $related = Cache::remember("product.related.{$product->brand_id}.{$product->id}", 3600, function () use ($product) {
            return Product::where('brand_id', $product->brand_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->with('brand')
                ->limit(5)
                ->get()
                ->map(fn($p) => [
                    'slug'  => $p->slug,
                    'name'  => $p->name,
                    'brand' => $p->brand?->name ?? '',
                    'image' => $p->image_url,
                ]);
        });

        return view('product.detail', compact('product', 'related'));
    }
}
