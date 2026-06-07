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

        $user = auth()->user();

        // Lấy tất cả đơn hàng đã giao chứa sản phẩm này của người dùng
        $ordersOfProduct = \App\Models\Order::where('orders.user_id', $user->id)
            ->where('orders.status', 'delivered')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.product_id', $product->id)
            ->select('orders.id')
            ->pluck('id');

        if ($ordersOfProduct->isEmpty()) {
            return back()->with('error', 'Bạn chỉ được đánh giá sản phẩm sau khi đã mua sản phẩm này.');
        }

        // Lấy các order_id đã được đánh giá
        $reviewedOrderIds = \App\Models\Review::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->whereIn('order_id', $ordersOfProduct)
            ->pluck('order_id');

        // Tìm đơn hàng chưa được đánh giá
        $eligibleOrderId = $ordersOfProduct->diff($reviewedOrderIds)->first();

        if (!$eligibleOrderId) {
            return back()->with('error', 'Bạn đã đánh giá hết các lượt mua cho sản phẩm này. Hãy tiếp tục mua hàng để đánh giá thêm.');
        }

        // Tạo đánh giá mới gắn với đơn hàng đó
        \App\Models\Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'order_id' => $eligibleOrderId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        // Cập nhật rating và số lượt đánh giá của sản phẩm
        $avgRating = $product->reviews()->avg('rating');
        $product->update([
            'rating' => round($avgRating, 2),
            'review_count' => $product->reviews()->count(),
        ]);

        return back()->with('success', 'Đánh giá sản phẩm thành công.');
    }
}