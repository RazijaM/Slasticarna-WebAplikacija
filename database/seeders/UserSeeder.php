<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@slasticarna.test'],
            [
                'name' => 'Admin',
                'surname' => 'Slasticarna',
                'password' => Hash::make('password'),
                'role' => 'ADMIN',
                'profile_image' => null,
            ]
        );

        // Customer users
        User::factory()
            ->count(5)
            ->create([
                'role' => 'CUSTOMER',
            ]);
    }
}

