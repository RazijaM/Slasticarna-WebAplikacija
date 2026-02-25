<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $statuses = [
            Order::STATUS_KREIRANA,
            Order::STATUS_PRIHVACENA,
            Order::STATUS_ODBIJENA,
            Order::STATUS_U_PRIPREMI,
            Order::STATUS_U_DOSTAVI,
            Order::STATUS_DOSTAVLJENA,
            Order::STATUS_OTKAZANA,
        ];

        return [
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'note' => fake()->boolean(40) ? fake()->sentence() : null,
            'status' => fake()->randomElement($statuses),
            'total' => 0,
        ];
    }
}

