<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        auth()->user()->update($validated);
        return back()->with('success', 'Profile updated successfully');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], auth()->user()->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        auth()->user()->update(['password' => Hash::make($validated['password'])]);
        return back()->with('success', 'Password changed successfully');
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);
        return view('profile.orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = auth()->user()->orders()->with('items.product')->findOrFail($id);
        return view('profile.order-detail', compact('order'));
    }

    public function wishlist()
    {
        $wishlists = auth()->user()->wishlists()->with('product')->paginate(12);
        return view('profile.wishlist', compact('wishlists'));
    }
}