<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $items->sum(fn ($item) => $item->product ? $item->product->price * $item->quantity : 0);

        return view('cart.index', compact('items', 'subtotal'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $qty = (int) ($request->input('quantity', 1));
        if ($qty < 1) {
            $qty = 1;
        }

        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Proizvod trenutno nije dostupan.');
        }

        $existing = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        $newQty = $qty + ($existing?->quantity ?? 0);

        if ($newQty > $product->stock) {
            $newQty = $product->stock;
        }

        CartItem::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ],
            [
                'quantity' => $newQty,
            ]
        );

        return redirect()
            ->route('cart.index')
            ->with('success', 'Proizvod je dodat u korpu.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        abort_unless($cartItem->user_id === auth()->id(), 403);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $request->input('quantity');

        $product = $cartItem->product;
        if (! $product || $product->stock <= 0) {
            $cartItem->delete();

            return redirect()
                ->route('cart.index')
                ->with('error', 'Proizvod više nije dostupan i uklonjen je iz korpe.');
        }

        if ($quantity > $product->stock) {
            $quantity = $product->stock;
        }

        $cartItem->update([
            'quantity' => $quantity,
        ]);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Količina je ažurirana.');
    }

    public function remove(CartItem $cartItem)
    {
        abort_unless($cartItem->user_id === auth()->id(), 403);

        $cartItem->delete();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Proizvod je uklonjen iz korpe.');
    }
}

