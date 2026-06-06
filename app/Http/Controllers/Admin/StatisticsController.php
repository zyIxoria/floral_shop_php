<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        // Get the date 30 days ago
        $thirtyDaysAgo = Carbon::now()->subDays(30)->startOfDay();

        // 1. Daily revenue for last 30 days
        $revenueStats = Order::where('status', 'delivered')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        // 2. Daily orders count for last 30 days
        $orderStats = Order::where('created_at', '>=', $thirtyDaysAgo)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // 3. Daily customer registrations for last 30 days
        $userStats = User::where('role', 'customer')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // Generate full 30 days timeline
        $dates = [];
        $revenueData = [];
        $orderData = [];
        $userData = [];

        for ($i = 30; $i >= 0; $i--) {
            $rawDate = Carbon::now()->subDays($i)->format('Y-m-d');
            $displayDate = Carbon::now()->subDays($i)->format('d/m');
            
            $dates[] = $displayDate;
            $revenueData[] = (float)($revenueStats[$rawDate] ?? 0);
            $orderData[] = (int)($orderStats[$rawDate] ?? 0);
            $userData[] = (int)($userStats[$rawDate] ?? 0);
        }

        // Summary cards data
        $totalRevenue = Order::where('status', 'delivered')->sum('total');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalProducts = Product::count();

        // Top 5 selling products (optional extra premium statistical card)
        $topProducts = Order::where('orders.status', 'delivered')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name, SUM(order_items.quantity) as total_quantity, SUM(order_items.quantity * order_items.price) as total_sales')
            ->groupBy('products.id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return view('admin.statistics.index', compact(
            'dates',
            'revenueData',
            'orderData',
            'userData',
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'totalProducts',
            'topProducts'
        ));
    }
}
