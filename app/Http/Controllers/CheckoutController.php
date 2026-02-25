<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function create()
    {
        $items = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Vaša korpa je prazna.');
        }

        $subtotal = $items->sum(fn ($item) => $item->product ? $item->product->price * $item->quantity : 0);

        return view('checkout.index', compact('items', 'subtotal'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
        ]);

        $userId = auth()->id();

        $items = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Vaša korpa je prazna.');
        }

        try {
            DB::transaction(function () use ($data, $items, $userId, &$order) {
                $subtotal = 0;

                foreach ($items as $cartItem) {
                    $product = $cartItem->product;

                    if (! $product || $product->stock <= 0 || ! $product->is_active) {
                        throw new \RuntimeException('Neki proizvodi više nisu dostupni.');
                    }

                    if ($cartItem->quantity > $product->stock) {
                        throw new \RuntimeException('Količina za proizvod "'.$product->name.'" prelazi dostupnu zalihu.');
                    }
                }

                foreach ($items as $cartItem) {
                    $product = $cartItem->product;
                    $lineTotal = $product->price * $cartItem->quantity;
                    $subtotal += $lineTotal;
                }

                $order = Order::create([
                    'user_id' => $userId,
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'note' => $data['note'] ?? null,
                    'status' => Order::STATUS_KREIRANA,
                    'total' => $subtotal,
                ]);

                foreach ($items as $cartItem) {
                    $product = $cartItem->product;
                    $quantity = $cartItem->quantity;
                    $lineTotal = $product->price * $quantity;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $product->price,
                        'line_total' => $lineTotal,
                    ]);

                    $product->decrement('stock', $quantity);
                }

                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'old_status' => null,
                    'new_status' => Order::STATUS_KREIRANA,
                    'changed_by' => $userId,
                    'note' => 'Narudžba kreirana.',
                ]);

                CartItem::where('user_id', $userId)->delete();
            });
        } catch (\Throwable $e) {
            return redirect()
                ->route('cart.index')
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Narudžba je uspješno kreirana.');
    }
}

