<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of active, in-stock products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', true)
            ->where('stock', '>', 0);

        $search = $request->input('q');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        $selectedCategoryId = $request->input('category_id');
        if ($selectedCategoryId) {
            $query->where('category_id', $selectedCategoryId);
        }

        $products = $query
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'selectedCategoryId' => $selectedCategoryId,
        ]);
    }

    /**
     * Display the specified product details.
     */
    public function show(Product $product)
    {
        abort_unless($product->is_active && $product->stock > 0, 404);

        $product->load('category');

        return view('products.show', compact('product'));
    }
}

