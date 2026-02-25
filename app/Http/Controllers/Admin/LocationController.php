<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RestaurantLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * Show the form for editing the restaurant location (single row: first or create).
     */
    public function edit(): View
    {
        $location = RestaurantLocation::first();

        if (! $location) {
            $location = new RestaurantLocation([
                'name' => '',
                'address' => '',
                'lat' => 43.8590,
                'lng' => 18.4290,
                'phone' => null,
                'delivery_radius_km' => null,
            ]);
        }

        return view('admin.location.edit', compact('location'));
    }

    /**
     * Update or create the restaurant location (single row scenario).
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
            'phone' => ['nullable', 'string', 'max:50'],
            'delivery_radius_km' => ['nullable', 'numeric', 'min:0'],
        ]);

        $location = RestaurantLocation::first();

        if ($location) {
            $location->update($validated);
        } else {
            RestaurantLocation::create($validated);
        }

        return redirect()->route('admin.location.edit')->with('success', __('Lokacija je spremljena.'));
    }
}
