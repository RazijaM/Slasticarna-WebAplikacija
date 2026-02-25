<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Moje narudžbe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($orders->isEmpty())
                        <p class="text-sm text-gray-500">
                            {{ __('Još uvijek nemate narudžbi.') }}
                        </p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Datum') }}
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Status') }}
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Ukupno') }}
                                        </th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Detalji') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                #{{ $order->id }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-500">
                                                {{ $order->created_at->format('d.m.Y H:i') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @class([
                                                        'bg-yellow-100 text-yellow-800' => $order->status === \App\Models\Order::STATUS_KREIRANA,
                                                        'bg-blue-100 text-blue-800' => in_array($order->status, [\App\Models\Order::STATUS_PRIHVACENA, \App\Models\Order::STATUS_U_PRIPREMI, \App\Models\Order::STATUS_U_DOSTAVI]),
                                                        'bg-green-100 text-green-800' => $order->status === \App\Models\Order::STATUS_DOSTAVLJENA,
                                                        'bg-red-100 text-red-800' => in_array($order->status, [\App\Models\Order::STATUS_ODBIJENA, \App\Models\Order::STATUS_OTKAZANA]),
                                                        'bg-gray-100 text-gray-800' => ! in_array($order->status, [
                                                            \App\Models\Order::STATUS_KREIRANA,
                                                            \App\Models\Order::STATUS_PRIHVACENA,
                                                            \App\Models\Order::STATUS_ODBIJENA,
                                                            \App\Models\Order::STATUS_U_PRIPREMI,
                                                            \App\Models\Order::STATUS_U_DOSTAVI,
                                                            \App\Models\Order::STATUS_DOSTAVLJENA,
                                                            \App\Models\Order::STATUS_OTKAZANA,
                                                        ]),
                                                    ])">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                {{ format_km($order->total) }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-right">
                                                <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ __('Prikaži') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

