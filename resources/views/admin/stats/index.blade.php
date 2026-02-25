<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistika') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">
                        {{ __('Ukupni prihod') }}
                    </h3>
                    <p class="text-3xl font-bold text-green-700">
                        {{ format_km($totalRevenue) }}
                    </p>
                    <p class="mt-1 text-xs text-gray-500">
                        {{ __('Otkazane i odbijene narudžbe nisu uključene.') }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">
                            {{ __('Narudžbe po statusu') }}
                        </h3>
                        <canvas id="ordersByStatusChart" height="200"></canvas>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">
                            {{ __('Top 5 proizvoda (po broju narudžbi)') }}
                        </h3>
                        <canvas id="topProductsChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ordersByStatusData = @json($ordersByStatus);
            const ordersByStatusCtx = document.getElementById('ordersByStatusChart').getContext('2d');

            new Chart(ordersByStatusCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(ordersByStatusData),
                    datasets: [{
                        label: '{{ __('Broj narudžbi') }}',
                        data: Object.values(ordersByStatusData),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgb(37, 99, 235)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0,
                        }
                    }
                }
            });

            const topProductsRaw = @json($topProducts->map(fn ($item) => [
                'name' => $item->product?->name ?? 'ID '.$item->product_id,
                'quantity' => $item->total_quantity,
            ]));

            const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
            new Chart(topProductsCtx, {
                type: 'bar',
                data: {
                    labels: topProductsRaw.map(p => p.name),
                    datasets: [{
                        label: '{{ __('Prodane količine') }}',
                        data: topProductsRaw.map(p => p.quantity),
                        backgroundColor: 'rgba(16, 185, 129, 0.5)',
                        borderColor: 'rgb(5, 150, 105)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true,
                            precision: 0,
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>

