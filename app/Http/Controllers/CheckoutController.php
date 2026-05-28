<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Services\OrderService;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $orderService;
    protected $couponService;

    public function __construct(OrderService $orderService, CouponService $couponService)
    {
        $this->orderService = $orderService;
        $this->couponService = $couponService;
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        return view('checkout.index', compact('user'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);

        $cart = auth()->user()->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 422);
        }

        $coupon = $this->couponService->validateCoupon(
            $request->coupon_code,
            $cart->getTotalPrice()
        );

        if (!$coupon) {
            return response()->json(['error' => 'Invalid or expired coupon'], 422);
        }

        $discount = $coupon->calculateDiscount($cart->getTotalPrice());

        return response()->json([
            'success' => true,
            'coupon_id' => $coupon->id,
            'discount' => $discount,
            'total' => $cart->getTotalPrice() - $discount,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'shipping_phone' => 'required|string',
            'shipping_email' => 'required|email',
            'payment_method' => 'required|in:cod,vnpay',
            'coupon_id' => 'nullable|exists:coupons,id',
            'notes' => 'nullable|string',
        ]);

        try {
            $order = $this->orderService->createOrder($validated, $validated['coupon_id'] ?? null);

            if ($validated['payment_method'] === 'vnpay') {
                // VNPay integration
                return redirect()->route('payment.vnpay', $order);
            }

            return redirect()->route('checkout.success', $order)
                           ->with('success', 'Order created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function success()
    {
        $order = auth()->user()->orders()->latest()->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}