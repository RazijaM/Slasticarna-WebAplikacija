<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plaćanje') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">
                        {{ __('Rezime narudžbe') }}
                    </h3>

                    <div class="mb-6 space-y-2">
                        @foreach ($items as $item)
                            @php($product = $item->product)
                            <div class="flex items-center justify-between text-sm">
                                <div>
                                    {{ $product?->name ?? __('Proizvod nedostupan') }}
                                    @if ($product)
                                        <span class="text-gray-500">x {{ $item->quantity }}</span>
                                    @endif
                                </div>
                                @if ($product)
                                    <div class="font-semibold">
                                        {{ format_km($product->price * $item->quantity) }}
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        <div class="border-t border-gray-200 pt-3 mt-3 flex items-center justify-between text-base font-semibold">
                            <span>{{ __('Ukupno') }}</span>
                            <span>{{ format_km($subtotal) }}</span>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">
                        {{ __('Detalji za dostavu') }}
                    </h3>

                    <form method="POST" action="{{ route('checkout.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="phone" :value="__('Telefon')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                          :value="old('phone')" required autofocus />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Adresa')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                          :value="old('address')" required />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="note" :value="__('Napomena (opcionalno)')" />
                            <textarea id="note" name="note" rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('note') }}</textarea>
                            <x-input-error :messages="$errors->get('note')" class="mt-2" />
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <a href="{{ route('cart.index') }}" class="text-sm text-gray-600 hover:text-gray-800">
                                {{ __('Nazad na korpu') }}
                            </a>

                            <x-primary-button>
                                {{ __('Potvrdi narudžbu') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

