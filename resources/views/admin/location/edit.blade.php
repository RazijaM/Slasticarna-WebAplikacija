<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lokacija slastičarne (admin)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-sm text-gray-600 mb-6">
                        {{ __('Ovi podaci se koriste na stranici Lokacija i u API-ju /api/location.') }}
                    </p>

                    <form method="POST" action="{{ route('admin.location.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Naziv')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                          value="{{ old('name', $location->name) }}" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Adresa')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                          value="{{ old('address', $location->address) }}" required />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="lat" :value="__('Širina (lat)')" />
                                <x-text-input id="lat" name="lat" type="number" step="any" class="mt-1 block w-full"
                                              value="{{ old('lat', $location->lat) }}" required />
                                <x-input-error :messages="$errors->get('lat')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="lng" :value="__('Duljina (lng)')" />
                                <x-text-input id="lng" name="lng" type="number" step="any" class="mt-1 block w-full"
                                              value="{{ old('lng', $location->lng) }}" required />
                                <x-input-error :messages="$errors->get('lng')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Telefon (opcionalno)')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                          value="{{ old('phone', $location->phone) }}" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="delivery_radius_km" :value="__('Radijus dostave (km, opcionalno)')" />
                            <x-text-input id="delivery_radius_km" name="delivery_radius_km" type="number" step="0.01" min="0" class="mt-1 block w-full"
                                          value="{{ old('delivery_radius_km', $location->delivery_radius_km) }}" />
                            <x-input-error :messages="$errors->get('delivery_radius_km')" class="mt-2" />
                        </div>

                        <div class="pt-4">
                            <x-primary-button>
                                {{ __('Spremi lokaciju') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
