<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserGrowthWidget extends ChartWidget
{
    protected static ?string $heading = 'Pertumbuhan User (6 Bulan Terakhir)';
    protected static ?int    $sort    = 3;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        // ✅ CHUNKING (GROUP BY): 1 query GROUP BY menggantikan loop 6 query terpisah.
        //    Cache 15 menit — grafik historis tidak butuh update real-time.
        [$labels, $data] = Cache::remember('filament.user_growth_widget', 900, function () {
            $from = now()->subMonths(5)->startOfMonth();

            // Ambil semua bulan sekaligus dengan 1 query GROUP BY
            $rows = User::where('created_at', '>=', $from)
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as total")
                ->groupBy('ym')
                ->orderBy('ym')
                ->pluck('total', 'ym');

            $labels = [];
            $counts = [];

            for ($i = 5; $i >= 0; $i--) {
                $month    = now()->subMonths($i);
                $labels[] = $month->format('M Y');
                $counts[] = (int) ($rows[$month->format('Y-m')] ?? 0);
            }

            return [$labels, $counts];
        });

        return [
            'datasets' => [
                [
                    'label'           => 'User Baru',
                    'data'            => $data,
                    'borderColor'     => '#6366f1',
                    'backgroundColor' => 'rgba(99,102,241,0.1)',
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
