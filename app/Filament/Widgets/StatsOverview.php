<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use App\Models\Brand;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // ✅ CHUNKING (aggregasi DB): gunakan 1 query per COUNT, tidak tarik semua baris.
        //    Cache 5 menit agar dashboard admin tidak memukul DB setiap refresh.
        $stats = Cache::remember('filament.stats_overview', 300, function () {
            return [
                'total_products'  => Product::count(),
                'active_products' => Product::where('is_active', true)->count(),
                'total_brands'    => Brand::count(),
                'total_users'     => User::count(),
                'total_reviews'   => Review::count(),
            ];
        });

        return [
            Stat::make('Total Parfum', $stats['total_products'])
                ->description('Produk aktif: ' . $stats['active_products'])
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-o-beaker'),

            Stat::make('Total Brand', $stats['total_brands'])
                ->description('Brand terdaftar')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('info')
                ->icon('heroicon-o-building-storefront'),

            Stat::make('Total User', $stats['total_users'])
                ->description('Pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning')
                ->icon('heroicon-o-users'),

            Stat::make('Total Review', $stats['total_reviews'])
                ->description('Ulasan masuk')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('danger')
                ->icon('heroicon-o-chat-bubble-left-right'),
        ];
    }
}
