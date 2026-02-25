<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lokacija slastičarne') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div id="location-info" class="mb-4 text-sm text-gray-700"></div>
                    <div id="map" class="w-full h-96 rounded-md border border-gray-200"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const infoEl = document.getElementById('location-info');
            const mapEl = document.getElementById('map');

            try {
                const response = await fetch('/api/location');
                if (!response.ok) {
                    throw new Error('Ne mogu učitati lokaciju.');
                }

                const data = await response.json();

                infoEl.textContent = `${data.name} – ${data.address}`;

                const map = L.map(mapEl).setView([data.lat, data.lng], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors',
                }).addTo(map);

                L.marker([data.lat, data.lng])
                    .addTo(map)
                    .bindPopup(`${data.name}<br>${data.address}`)
                    .openPopup();
            } catch (error) {
                console.error(error);
                infoEl.textContent = '{{ __('Greška pri učitavanju lokacije.') }}';
            }
        });
    </script>
</x-app-layout>

