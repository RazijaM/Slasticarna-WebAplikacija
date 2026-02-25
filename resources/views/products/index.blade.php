<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proizvodi') }}
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
                    <div id="weather-widget" class="mb-6 inline-flex items-center px-4 py-2 rounded-md bg-blue-50 text-blue-800 text-sm">
                        {{ __('Učitavanje vremenske prognoze...') }}
                    </div>

                    <form method="GET" action="{{ route('products.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">
                                {{ __('Kategorija') }}
                            </label>
                            <select
                                id="category_id"
                                name="category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                                <option value="">{{ __('Sve kategorije') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected((string) $selectedCategoryId === (string) $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="q" class="block text-sm font-medium text-gray-700">
                                {{ __('Pretraga') }}
                            </label>
                            <input
                                type="text"
                                id="q"
                                name="q"
                                value="{{ $search }}"
                                placeholder="{{ __('Pretraži po nazivu ili opisu...') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                        </div>

                        <div class="flex space-x-2 md:justify-end">
                            <x-secondary-button type="submit">
                                {{ __('Filtriraj') }}
                            </x-secondary-button>

                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                {{ __('Reset') }}
                            </a>
                        </div>
                    </form>

                    @if ($products->isEmpty())
                        <p class="text-sm text-gray-500">
                            {{ __('Trenutno nema dostupnih proizvoda.') }}
                        </p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($products as $product)
                                <div class="border border-gray-200 rounded-lg overflow-hidden flex flex-col">
                                    @if ($product->image_path)
                                        <img
                                            src="{{ asset('storage/'.$product->image_path) }}"
                                            alt="{{ $product->name }}"
                                            class="h-40 w-full object-cover"
                                        >
                                    @endif

                                    <div class="p-4 flex-1 flex flex-col">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                <a href="{{ route('products.show', $product) }}" class="hover:underline">
                                                    {{ $product->name }}
                                                </a>
                                            </h3>
                                            @if ($product->category)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                                    {{ $product->category->name }}
                                                </span>
                                            @endif
                                        </div>

                                        <p class="text-sm text-gray-700 mb-3 line-clamp-3">
                                            {{ $product->description }}
                                        </p>

                                        <div class="mt-auto">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="text-lg font-bold text-gray-900">
                                                    {{ format_km($product->price) }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ __('Na stanju') }}: {{ $product->stock }}
                                                </span>
                                            </div>

                                            @auth
                                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    <input
                                                        type="number"
                                                        name="quantity"
                                                        min="1"
                                                        max="{{ $product->stock }}"
                                                        value="1"
                                                        class="w-20 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                                    >
                                                    <x-primary-button>
                                                        {{ __('Dodaj u korpu') }}
                                                    </x-primary-button>
                                                </form>
                                            @else
                                                <p class="text-xs text-gray-500">
                                                    {{ __('Prijavite se da biste dodali u korpu.') }}
                                                </p>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const el = document.getElementById('weather-widget');
            if (!el) return;

            const fallbackMessage = '{{ __('Temperatura nije dostupna.') }}';

            try {
                const response = await fetch('/api/weather');
                if (!response.ok) {
                    el.textContent = fallbackMessage;
                    return;
                }

                const data = await response.json();
                const name = data.name || 'Lokacija slastičarne';
                const unit = data.unit || '°C';

                if (data.temperature === null || data.temperature === undefined) {
                    el.textContent = fallbackMessage;
                } else {
                    el.textContent = `${name}: ${Number(data.temperature).toFixed(1)}${unit}`;
                }
            } catch (error) {
                console.error(error);
                el.textContent = fallbackMessage;
            }
        });
    </script>
</x-app-layout>

