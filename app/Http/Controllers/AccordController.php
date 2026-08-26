<?php
namespace App\Http\Controllers;

use App\Models\Accord;
use Illuminate\Support\Facades\Cache;

class AccordController extends Controller
{
    public function index()
    {
        $accords = Cache::remember('accords.index', 3600, function () {
            return Accord::withCount('products')->get()
                ->map(fn($a) => [
                    'slug'           => $a->slug,
                    'name'           => $a->name,
                    'color'          => $a->color,
                    'products_count' => $a->products_count,
                ])->toArray();
        });

        return view('accords.index', compact('accords'));
    }

    public function show(string $slug)
    {
        $accord = Cache::remember("accord.{$slug}", 1800, function () use ($slug) {
            return Accord::where('slug', $slug)
                ->with(['products' => fn($q) => $q->where('is_active', true)->with('brand')])
                ->firstOrFail();
        });

        return view('accords.show.dynamic', compact('accord'));
    }
}
