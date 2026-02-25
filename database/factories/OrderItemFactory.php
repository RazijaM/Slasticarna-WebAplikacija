<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 5);

        $productId = Product::query()->inRandomOrder()->value('id') ?? Product::factory();

        // unit_price and line_total will be set in seeder from actual product
        return [
            'order_id' => Order::factory(),
            'product_id' => $productId,
            'quantity' => $quantity,
            'unit_price' => 0,
            'line_total' => 0,
        ];
    }
}

