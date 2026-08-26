<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6">

        {{-- Top Parfum by Review --}}
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <h2 class="text-base font-semibold text-gray-950 dark:text-white mb-4">🏆 Parfum Paling Populer (Berdasarkan Review)</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700 text-left text-gray-500 dark:text-gray-400">
                        <th class="pb-2 pr-4">#</th>
                        <th class="pb-2 pr-4">Nama Parfum</th>
                        <th class="pb-2 pr-4">Brand</th>
                        <th class="pb-2">Jumlah Review</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $i => $product)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="py-2 pr-4 font-bold text-gray-400">{{ $i + 1 }}</td>
                        <td class="py-2 pr-4 font-semibold text-gray-900 dark:text-white">{{ $product->name }}</td>
                        <td class="py-2 pr-4 text-gray-500">{{ $product->brand?->name ?? '-' }}</td>
                        <td class="py-2">
                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400">
                                {{ $product->reviews_count }} review
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    @if($topProducts->isEmpty())
                    <tr><td colspan="4" class="py-4 text-center text-gray-400">Belum ada data review</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Top Rated --}}
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <h2 class="text-base font-semibold text-gray-950 dark:text-white mb-4">⭐ Parfum Rating Tertinggi</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700 text-left text-gray-500 dark:text-gray-400">
                        <th class="pb-2 pr-4">#</th>
                        <th class="pb-2 pr-4">Slug Parfum</th>
                        <th class="pb-2 pr-4">Rata-rata Rating</th>
                        <th class="pb-2">Total Review</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topRated as $i => $item)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="py-2 pr-4 font-bold text-gray-400">{{ $i + 1 }}</td>
                        <td class="py-2 pr-4 font-semibold text-gray-900 dark:text-white">{{ $item->product_slug }}</td>
                        <td class="py-2 pr-4">
                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700">
                                ★ {{ number_format($item->avg_rating, 1) }}
                            </span>
                        </td>
                        <td class="py-2 text-gray-500">{{ $item->total }}</td>
                    </tr>
                    @endforeach
                    @if($topRated->isEmpty())
                    <tr><td colspan="4" class="py-4 text-center text-gray-400">Belum ada data review</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <h2 class="text-base font-semibold text-gray-950 dark:text-white mb-4">📈 Pertumbuhan User (6 Bulan)</h2>
                <canvas id="userChart" height="200"></canvas>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <h2 class="text-base font-semibold text-gray-950 dark:text-white mb-4">💬 Review per Bulan (6 Bulan)</h2>
                <canvas id="reviewChart" height="200"></canvas>
            </div>
        </div>

    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const userLabels  = {!! $userMonths !!};
        const userData    = {!! $userCounts !!};
        const reviewLabels = {!! $reviewMonths !!};
        const reviewData   = {!! $reviewCounts !!};

        new Chart(document.getElementById('userChart'), {
            type: 'line',
            data: {
                labels: userLabels,
                datasets: [{
                    label: 'User Baru',
                    data: userData,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.1)',
                    fill: true, tension: 0.4,
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('reviewChart'), {
            type: 'bar',
            data: {
                labels: reviewLabels,
                datasets: [{
                    label: 'Review',
                    data: reviewData,
                    backgroundColor: 'rgba(245,158,11,0.7)',
                    borderRadius: 6,
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    </script>
    @endpush
</x-filament-panels::page>
