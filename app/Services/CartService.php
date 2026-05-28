<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    public function getOrCreateCart()
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    public function addToCart(int $productId, int $quantity = 1)
    {
        $cart = $this->getOrCreateCart();
        $product = Product::findOrFail($productId);

        if (!$product->isInStock()) {
            throw new \Exception('Product is out of stock');
        }

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $quantity]);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return $cart;
    }

    public function updateCartItem(int $cartItemId, int $quantity)
    {
        $cartItem = $this->getOrCreateCart()->items()->findOrFail($cartItemId);

        if ($quantity <= 0) {
            $cartItem->delete();
        } else {
            $cartItem->update(['quantity' => $quantity]);
        }
    }

    public function removeFromCart(int $cartItemId)
    {
        $this->getOrCreateCart()->items()->findOrFail($cartItemId)->delete();
    }

    public function clearCart()
    {
        $this->getOrCreateCart()->items()->delete();
    }
}
