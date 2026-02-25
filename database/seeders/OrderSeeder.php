<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Product::count() === 0) {
            return;
        }

        // Create 10 random orders with items
        Order::factory()
            ->count(10)
            ->create()
            ->each(function (Order $order) {
                $itemsCount = rand(1, 5);
                $productIds = Product::inRandomOrder()->limit($itemsCount)->get();

                $total = 0;

                foreach ($productIds as $product) {
                    $quantity = rand(1, 5);
                    $unitPrice = $product->price;
                    $lineTotal = $unitPrice * $quantity;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'line_total' => $lineTotal,
                    ]);

                    $total += $lineTotal;
                }

                $order->update(['total' => $total]);
            });
    }
}

