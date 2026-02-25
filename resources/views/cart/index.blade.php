<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Korpa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($items->isEmpty())
                        <p class="text-sm text-gray-500">
                            {{ __('Vaša korpa je prazna.') }}
                        </p>
                    @else
                        <div class="space-y-4">
                            @foreach ($items as $item)
                                @php($product = $item->product)
                                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                    <div class="flex items-center space-x-4">
                                        @if ($product?->image_path)
                                            <img
                                                src="{{ asset('storage/'.$product->image_path) }}"
                                                alt="{{ $product->name }}"
                                                class="h-16 w-16 rounded object-cover"
                                            >
                                        @endif

                                        <div>
                                            <div class="font-semibold text-gray-900">
                                                {{ $product?->name ?? __('Proizvod nedostupan') }}
                                            </div>
                                            @if ($product)
                                                <div class="text-sm text-gray-500">
                                                    {{ format_km($product->price) }} / {{ __('kom') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        @if ($product)
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <input
                                                type="number"
                                                name="quantity"
                                                min="1"
                                                max="{{ $product->stock }}"
                                                value="{{ $item->quantity }}"
                                                class="w-20 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                            >
                                            <x-secondary-button type="submit">
                                                {{ __('Ažuriraj') }}
                                            </x-secondary-button>
                                        </form>
                                        @endif

                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="text-red-600 hover:text-red-800 text-sm"
                                            >
                                                {{ __('Ukloni') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <div class="text-lg font-semibold text-gray-900">
                                {{ __('Ukupno') }}: {{ format_km($subtotal) }}
                            </div>

                            <a href="{{ route('checkout.show') }}">
                                <x-primary-button>
                                    {{ __('Nastavi na plaćanje') }}
                                </x-primary-button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

