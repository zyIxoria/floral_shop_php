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
            'address_street' => 'required|string',
            'address_ward' => 'required|string',
            'address_district' => 'required|string',
            'address_city' => 'required|string',
            'shipping_phone' => ['required', 'string', 'regex:/^(03|05|07|08|09)[0-9]{8}$/'],
            'shipping_email' => 'required|email',
            'payment_method' => 'required|in:cod,vnpay,bank_transfer',
            'coupon_id' => 'nullable|exists:coupons,id',
            'notes' => 'nullable|string',
        ], [
            'shipping_phone.regex' => 'Số điện thoại phải có 10 chữ số và bắt đầu bằng các đầu số hợp lệ của Việt Nam (03, 05, 07, 08, 09).'
        ]);

        $validated['shipping_address'] = implode(', ', [
            $validated['address_street'],
            $validated['address_ward'],
            $validated['address_district'],
            $validated['address_city']
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
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function success()
    {
        $order = auth()->user()->orders()->latest()->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
