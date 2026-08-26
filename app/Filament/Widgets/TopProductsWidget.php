<?php

namespace App\Filament\Widgets;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TopProductsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        // ✅ CHUNKING (GROUP BY): ganti 7 query per-hari dengan 1 query GROUP BY.
        //    Cache 10 menit agar grafik tidak menghantam DB tiap refresh.
        $stats = Cache::remember('filament.top_products_widget', 600, function () {

            // ── Hitung totals (4 query COUNT, bukan tarik semua baris) ──────────
            $totalProducts  = Product::count();
            $activeProducts = Product::where('is_active', true)->count();
            $totalBrands    = Brand::count();
            $totalReviews   = Review::count();
            $totalUsers     = User::count();

            // Rata-rata rating keseluruhan — 1 query AVG
            $avgRating = $totalReviews > 0
                ? round(
                    Review::avg(DB::raw('(sillage + projection + longevity) / 3')),
                    1
                )
                : 0;

            // Review & user baru bulan ini — 2 query COUNT
            $reviewsThisMonth  = Review::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            $newUsersThisMonth = User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            // ── Chart sparkline: 7 hari terakhir via GROUP BY ────────────────────
            // ✅ CHUNKING: 1 query GROUP BY menggantikan 7 query terpisah per model
            $from = now()->subDays(6)->startOfDay();

            $productDayRows = Product::where('created_at', '>=', $from)
                ->selectRaw("DATE(created_at) as d, COUNT(*) as total")
                ->groupBy('d')
                ->pluck('total', 'd');

            $reviewDayRows  = Review::where('created_at', '>=', $from)
                ->selectRaw("DATE(created_at) as d, COUNT(*) as total")
                ->groupBy('d')
                ->pluck('total', 'd');

            $userDayRows    = User::where('created_at', '>=', $from)
                ->selectRaw("DATE(created_at) as d, COUNT(*) as total")
                ->groupBy('d')
                ->pluck('total', 'd');

            // Bangun array 7 elemen dari peta hari di atas
            $productChart = [];
            $reviewChart  = [];
            $userChart    = [];

            for ($i = 6; $i >= 0; $i--) {
                $day            = now()->subDays($i)->toDateString();
                $productChart[] = (int) ($productDayRows[$day] ?? 0);
                $reviewChart[]  = (int) ($reviewDayRows[$day]  ?? 0);
                $userChart[]    = (int) ($userDayRows[$day]    ?? 0);
            }

            return compact(
                'totalProducts', 'activeProducts', 'totalBrands',
                'totalReviews', 'totalUsers', 'avgRating',
                'reviewsThisMonth', 'newUsersThisMonth',
                'productChart', 'reviewChart', 'userChart'
            );
        });

        return [
            Stat::make('Total Parfum', $stats['totalProducts'])
                ->description($stats['activeProducts'] . ' aktif · ' . ($stats['totalProducts'] - $stats['activeProducts']) . ' nonaktif')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary')
                ->chart($stats['productChart']),

            Stat::make('Total Brand', $stats['totalBrands'])
                ->description('Brand terdaftar')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('warning'),

            Stat::make('Total Review', $stats['totalReviews'])
                ->description('+' . $stats['reviewsThisMonth'] . ' bulan ini')
                ->descriptionIcon('heroicon-m-star')
                ->color('success')
                ->chart($stats['reviewChart']),

            Stat::make('Rating Rata-rata', $stats['avgRating'] . ' / 5')
                ->description('Dari ' . $stats['totalReviews'] . ' review pengguna')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color($stats['avgRating'] >= 4 ? 'success' : ($stats['avgRating'] >= 3 ? 'warning' : 'danger')),

            Stat::make('Total Pengguna', $stats['totalUsers'])
                ->description('+' . $stats['newUsersThisMonth'] . ' baru bulan ini')
                ->descriptionIcon('heroicon-m-users')
                ->color('info')
                ->chart($stats['userChart']),
        ];
    }
}
