<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $totalRevenue = Order::where('status', 'delivered')
                            ->sum('total');
        $totalOrders = Order::count();
        $totalUsers = User::where('role', 'customer')->count();
        $totalProducts = Product::count();
        $recentOrders = Order::with('user')
                            ->latest()
                            ->limit(10)
                            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalUsers',
            'totalProducts',
            'recentOrders'
        ));
    }
}