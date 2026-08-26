<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Brand;

class Laporan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Laporan';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $title = 'Laporan & Analisis';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.laporan';

    public function getViewData(): array
    {
        // ✅ EAGER LOADING: muat brand sekaligus saat query top products
        $topProducts = Product::withCount('reviews')
            ->with('brand:id,name')
            ->orderByDesc('reviews_count')
            ->limit(5)
            ->get();

        // Top 5 by average rating — aggregasi langsung di DB
        $topRated = Review::selectRaw('product_slug, COUNT(*) as total, AVG((sillage+projection+longevity)/3) as avg_rating')
            ->groupBy('product_slug')
            ->orderByDesc('avg_rating')
            ->limit(5)
            ->get();

        // ✅ CHUNKING: hitung user per bulan menggunakan 1 query + group by,
        //    bukan 6 query terpisah (lebih efisien untuk dataset besar)
        $userMonths  = [];
        $userCounts  = [];
        $userRows = User::where('role', 'user')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as total")
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym');

        for ($i = 5; $i >= 0; $i--) {
            $month        = now()->subMonths($i);
            $key          = $month->format('Y-m');
            $userMonths[] = $month->format('M Y');
            $userCounts[] = (int) ($userRows[$key] ?? 0);
        }

        // ✅ CHUNKING: hitung review per bulan — 1 query + group by
        $reviewMonths  = [];
        $reviewCounts  = [];
        $reviewRows = Review::where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as total")
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym');

        for ($i = 5; $i >= 0; $i--) {
            $month          = now()->subMonths($i);
            $key            = $month->format('Y-m');
            $reviewMonths[] = $month->format('M Y');
            $reviewCounts[] = (int) ($reviewRows[$key] ?? 0);
        }

        return [
            'topProducts'   => $topProducts,
            'topRated'      => $topRated,
            'userMonths'    => json_encode($userMonths),
            'userCounts'    => json_encode($userCounts),
            'reviewMonths'  => json_encode($reviewMonths),
            'reviewCounts'  => json_encode($reviewCounts),
            'totalProducts' => Product::count(),
            'totalBrands'   => Brand::count(),
            'totalUsers'    => User::where('role', 'user')->count(),
            'totalReviews'  => Review::count(),
        ];
    }
}
