<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    /**
     * Get current temperature by coordinates using Open-Meteo API.
     *
     * @return array{name: string, lat: float, lng: float, temperature: float|null, unit: string}
     */
    public function getCurrentTemperatureByCoordinates(float $lat, float $lng, string $name = 'Lokacija slastičarne'): array
    {
        $weatherResponse = Http::timeout(5)->get('https://api.open-meteo.com/v1/forecast', [
            'latitude' => $lat,
            'longitude' => $lng,
            'current' => 'temperature_2m',
            'timezone' => 'auto',
        ]);

        if (! $weatherResponse->ok()) {
            return [
                'name' => $name,
                'lat' => $lat,
                'lng' => $lng,
                'temperature' => null,
                'unit' => '°C',
            ];
        }

        $weatherData = $weatherResponse->json();
        $temperature = $weatherData['current']['temperature_2m'] ?? null;

        return [
            'name' => $name,
            'lat' => $lat,
            'lng' => $lng,
            'temperature' => is_numeric($temperature) ? (float) $temperature : null,
            'unit' => '°C',
        ];
    }

    /**
     * Get current temperature for a given city (geocoding + forecast).
     * Kept for backwards compatibility if needed.
     *
     * @return array{city: string, temperature: float|null}
     */
    public function getCurrentTemperature(string $city): array
    {
        $city = trim($city) ?: 'Sarajevo';

        $geoResponse = Http::timeout(5)->get('https://geocoding-api.open-meteo.com/v1/search', [
            'name' => $city,
            'count' => 1,
            'language' => 'en',
            'format' => 'json',
        ]);

        if (! $geoResponse->ok()) {
            return ['city' => $city, 'temperature' => null];
        }

        $geoData = $geoResponse->json();
        if (empty($geoData['results'][0])) {
            return ['city' => $city, 'temperature' => null];
        }

        $result = $geoData['results'][0];
        $byCoords = $this->getCurrentTemperatureByCoordinates(
            (float) $result['latitude'],
            (float) $result['longitude'],
            $result['name'] ?? $city
        );

        return [
            'city' => $byCoords['name'],
            'temperature' => $byCoords['temperature'],
        ];
    }
}

