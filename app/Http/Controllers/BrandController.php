<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Cache::remember('brands.index', 3600, function () {
            return Brand::withCount('products')->get()
                ->map(fn($b) => [
                    'slug'           => $b->slug,
                    'name'           => $b->name,
                    'logo'           => $b->logo_url,
                    'products_count' => $b->products_count,
                ])->toArray();
        });

        return view('brands.index', compact('brands'));
    }

    public function show(string $slug)
    {
        $brand = Cache::remember("brand.{$slug}", 1800, function () use ($slug) {
            return Brand::where('slug', $slug)
                ->with(['products' => fn($q) => $q->where('is_active', true)->orderBy('name')->with('brand')])
                ->firstOrFail();
        });

        return view('brands.show.dynamic', compact('brand'));
    }
}
