<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Narudžba') }} #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-2">
                    <div><span class="font-semibold">{{ __('Status') }}:</span> {{ $order->status }}</div>
                    <div><span class="font-semibold">{{ __('Datum') }}:</span> {{ $order->created_at->format('d.m.Y H:i') }}</div>
                    <div><span class="font-semibold">{{ __('Telefon') }}:</span> {{ $order->phone }}</div>
                    <div><span class="font-semibold">{{ __('Adresa') }}:</span> {{ $order->address }}</div>
                    @if ($order->note)
                        <div><span class="font-semibold">{{ __('Napomena') }}:</span> {{ $order->note }}</div>
                    @endif
                    <div><span class="font-semibold">{{ __('Ukupno') }}:</span> {{ format_km($order->total) }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">
                        {{ __('Stavke narudžbe') }}
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Proizvod') }}
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Količina') }}
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Cijena') }}
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Ukupno') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $item->product?->name ?? __('Proizvod obrisan') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ format_km($item->unit_price) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ format_km($item->line_total) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">
                        {{ __('Historija statusa') }}
                    </h3>

                    @if ($order->statusLogs->isEmpty())
                        <p class="text-sm text-gray-500">
                            {{ __('Nema zabilježenih promjena statusa.') }}
                        </p>
                    @else
                        <ul class="space-y-2 text-sm">
                            @foreach ($order->statusLogs as $log)
                                <li class="border-b border-gray-100 pb-2">
                                    <div class="font-semibold">
                                        {{ $log->created_at?->format('d.m.Y H:i') }}
                                        - {{ $log->old_status ?? '—' }} → {{ $log->new_status }}
                                    </div>
                                    <div class="text-gray-600">
                                        @if ($log->changedBy)
                                            {{ __('Promijenio:') }} {{ $log->changedBy->name }}
                                        @endif
                                    </div>
                                    @if ($log->note)
                                        <div class="text-gray-700">
                                            {{ $log->note }}
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

