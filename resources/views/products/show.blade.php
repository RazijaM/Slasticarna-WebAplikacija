<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 md:flex md:space-x-6">
                    @if ($product->image_path)
                        <div class="md:w-1/3 mb-4 md:mb-0">
                            <img
                                src="{{ asset('storage/'.$product->image_path) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-64 object-cover rounded"
                            >
                        </div>
                    @endif

                    <div class="md:flex-1 space-y-4">
                        @if ($product->category)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                {{ $product->category->name }}
                            </span>
                        @endif

                        <p class="text-gray-700">
                            {{ $product->description }}
                        </p>

                        <div class="flex items-center space-x-4">
                            <span class="text-2xl font-bold text-gray-900">
                                {{ format_km($product->price) }}
                            </span>
                            <span class="text-sm text-gray-500">
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
                                    class="w-24 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
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
        </div>
    </div>
</x-app-layout>

