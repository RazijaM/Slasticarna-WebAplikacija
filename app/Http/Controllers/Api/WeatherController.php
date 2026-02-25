<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RestaurantLocation;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    /**
     * Return current weather at the restaurant location (from DB).
     * GET /api/weather
     */
    public function __invoke(WeatherService $weatherService): JsonResponse
    {
        $location = RestaurantLocation::first();

        if (! $location) {
            return response()->json([
                'name' => 'Lokacija slastičarne',
                'lat' => null,
                'lng' => null,
                'temperature' => null,
                'unit' => '°C',
            ], 200);
        }

        $name = trim($location->name) !== '' ? $location->name : 'Lokacija slastičarne';
        $data = $weatherService->getCurrentTemperatureByCoordinates(
            (float) $location->lat,
            (float) $location->lng,
            $name
        );

        return response()->json($data);
    }
}
