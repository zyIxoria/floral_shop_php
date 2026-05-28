<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $featuredProducts = Product::where('status', 'active')
                                  ->orderBy('created_at', 'desc')
                                  ->limit(8)
                                  ->get();
        $saleProducts = Product::where('status', 'active')
                              ->whereNotNull('sale_price')
                              ->limit(6)
                              ->get();
        $reviews = Review::with('user', 'product')
                        ->latest()
                        ->limit(6)
                        ->get();

        return view('home.index', compact('categories', 'featuredProducts', 'saleProducts', 'reviews'));
    }

    public function shop(string $category = null)
    {
        $query = Product::where('status', 'active');

        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $sort = request('sort', 'newest');
        $search = request('search');

        if ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }

        $query = match($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('products.shop', compact('products', 'categories', 'category', 'sort', 'search'));
    }
}