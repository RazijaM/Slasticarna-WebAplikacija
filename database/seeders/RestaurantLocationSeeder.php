<?php

namespace Database\Seeders;

use App\Models\RestaurantLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantLocationSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RestaurantLocation::firstOrCreate(
            ['name' => 'Slastičarna Slatki Raj'],
            [
                'address' => 'Sarajevo, Ferhadija 1',
                'lat' => 43.8590,
                'lng' => 18.4290,
            ]
        );
    }
}

