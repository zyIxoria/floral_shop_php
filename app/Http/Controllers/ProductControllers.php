<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
                                 ->where('id', '!=', $product->id)
                                 ->limit(4)
                                 ->get();
        $reviews = $product->reviews()->with('user')->get();

        return view('products.show', compact('product', 'relatedProducts', 'reviews'));
    }

    public function addReview(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $product->reviews()->updateOrCreate(
            ['user_id' => auth()->id()],
            $validated
        );

        // Update product rating
        $avgRating = $product->reviews()->avg('rating');
        $product->update([
            'rating' => round($avgRating, 2),
            'review_count' => $product->reviews()->count(),
        ]);

        return back()->with('success', 'Review added successfully');
    }
}