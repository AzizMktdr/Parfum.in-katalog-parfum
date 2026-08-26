<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class FragranceController extends Controller
{
    public function index()
    {
        [$fragrances, $byBrand] = Cache::remember('fragrances.index', 3600, function () {
            $fragrances = Product::where('is_active', true)
                ->with('brand')
                ->orderBy('name')
                ->get()
                ->map(fn($p) => [
                    'slug'       => $p->slug,
                    'name'       => $p->name,
                    'brand'      => $p->brand?->name ?? '',
                    'brand_slug' => $p->brand?->slug ?? '',
                    'image'      => $p->image_url,
                ])->toArray();

            $byBrand = [];
            foreach ($fragrances as $f) {
                $byBrand[$f['brand']][] = $f;
            }

            return [$fragrances, $byBrand];
        });

        return view('fragrances.index', compact('fragrances', 'byBrand'));
    }
}
