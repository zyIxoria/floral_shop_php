<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Support\Str;

class OrderService
{
    public function createOrder(array $data, ?int $couponId = null): Order
    {
        $cart = Cart::where('user_id', auth()->id())->firstOrFail();

        if ($cart->items->isEmpty()) {
            throw new \Exception('Cart is empty');
        }

        $subtotal = $cart->getTotalPrice();
        $discount = 0;

        if ($couponId) {
            $coupon = Coupon::findOrFail($couponId);
            if ($coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
            }
        }

        $total = $subtotal - $discount;

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . date('Ymd') . '-' . Str::random(8),
            'shipping_address' => $data['shipping_address'],
            'shipping_phone' => $data['shipping_phone'],
            'shipping_email' => $data['shipping_email'],
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'payment_method' => $data['payment_method'] ?? 'cod',
            'notes' => $data['notes'] ?? null,
        ]);

        // Create order items
        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->getCurrentPrice(),
            ]);

            // Reduce stock
            $item->product->decrement('stock', $item->quantity);
        }

        // Create payment
        $order->payment()->create([
            'method' => $order->payment_method,
            'amount' => $order->total,
            'status' => 'pending',
        ]);

        // Record coupon usage
        if ($couponId) {
            $coupon->usages()->create([
                'user_id' => auth()->id(),
                'order_id' => $order->id,
            ]);
            $coupon->increment('used_count');
        }

        // Clear cart
        $cart->items()->delete();

        return $order;
    }

    public function updateOrderStatus(Order $order, string $status)
    {
        $order->update(['status' => $status]);

        if ($status === 'delivered') {
            $order->payment->update(['status' => 'completed', 'paid_at' => now()]);
        }

        return $order;
    }

    public function cancelOrder(Order $order)
    {
        // Update order status
        $order->update(['status' => 'cancelled']);

        // Update payment status
        if ($order->payment) {
            $order->payment->update(['status' => 'failed']);
        }

        // Restore product stock
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        // Restore coupon usage
        if ($order->couponUsage) {
            $coupon = $order->couponUsage->coupon;
            if ($coupon) {
                if ($coupon->used_count > 0) {
                    $coupon->decrement('used_count');
                }
            }
            $order->couponUsage->delete();
        }

        return $order;
    }
}
