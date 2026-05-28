<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
        ]);

        return back()->with('success', 'Added to wishlist');
    }

    public function remove(int $productId)
    {
        Wishlist::where('user_id', auth()->id())
               ->where('product_id', $productId)
               ->delete();

        return back()->with('success', 'Removed from wishlist');
    }
}