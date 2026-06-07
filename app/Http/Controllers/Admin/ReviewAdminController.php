<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $productId = $request->input('product_id');
        $ratingFilter = $request->input('rating');

        $query = Review::with(['user', 'product', 'order']);

        // Apply filters
        if ($productId) {
            $query->where('product_id', $productId);
        }
        if ($ratingFilter) {
            $query->where('rating', $ratingFilter);
        }

        // Calculate statistics based on product filter
        $statsQuery = Review::query();
        if ($productId) {
            $statsQuery->where('product_id', $productId);
        }
        
        $totalReviews = $statsQuery->count();
        $averageRating = round($statsQuery->avg('rating') ?? 0, 1);

        // Get reviews list
        $reviews = $query->latest()->paginate(15)->withQueryString();

        // Get all products for filter dropdown
        $products = Product::orderBy('name')->get();

        return view('admin.reviews.index', compact(
            'reviews',
            'products',
            'totalReviews',
            'averageRating',
            'productId',
            'ratingFilter'
        ));
    }

    public function destroy(Review $review)
    {
        $product = $review->product;
        $review->delete();

        // Recalculate product rating
        if ($product) {
            $avgRating = $product->reviews()->avg('rating') ?? 0;
            $product->update([
                'rating' => round($avgRating, 2),
                'review_count' => $product->reviews()->count(),
            ]);
        }

        return back()->with('success', 'Đánh giá đã được xóa thành công.');
    }
}
