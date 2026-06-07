<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;
    protected $couponService;

    public function __construct(CartService $cartService, \App\Services\CouponService $couponService)
    {
        $this->cartService = $cartService;
        $this->couponService = $couponService;
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = $this->cartService->getOrCreateCart();
        
        $appliedCoupon = null;
        $discount = 0;
        $couponCode = session('applied_coupon_code');

        if ($couponCode && $cart && !$cart->items->isEmpty()) {
            $appliedCoupon = $this->couponService->validateCoupon($couponCode, $cart->getTotalPrice());
            if ($appliedCoupon) {
                $discount = $appliedCoupon->calculateDiscount($cart->getTotalPrice());
            } else {
                session()->forget('applied_coupon_code');
            }
        }

        return view('cart.index', compact('cart', 'appliedCoupon', 'discount'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $this->cartService->addToCart($validated['product_id'], $validated['quantity']);
            
            if ($request->input('action') === 'buy_now') {
                return redirect()->route('checkout.index');
            }
            
            return back()->with('success', 'Product added to cart');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, int $cartItemId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $this->cartService->updateCartItem($cartItemId, $validated['quantity']);
        return back()->with('success', 'Cart updated');
    }

    public function remove(int $cartItemId)
    {
        $this->cartService->removeFromCart($cartItemId);
        return back()->with('success', 'Item removed from cart');
    }

    public function clear()
    {
        $this->cartService->clearCart();
        return back()->with('success', 'Cart cleared');
    }
}