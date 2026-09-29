<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories', 'sort'));
    }

    public function show(string $slug)
    {
        $product  = Product::active()->where('slug', $slug)->with('category', 'reviews.user')->firstOrFail();
        $related  = Product::active()
                        ->where('category_id', $product->category_id)
                        ->where('id', '!=', $product->id)
                        ->take(4)->get();
        return view('products.show', compact('product', 'related'));
    }

    public function search(Request $request)
    {
        $q        = $request->get('q', '');
        $products = Product::active()
                        ->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->with('category')
                        ->paginate(12)
                        ->withQueryString();
        return view('products.search', compact('products', 'q'));
    }
}
