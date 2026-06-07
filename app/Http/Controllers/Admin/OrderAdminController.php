<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->middleware('admin');
        $this->orderService = $orderService;
    }

    public function index()
    {
        $search = request('search');
        $status = request('status');

        $query = Order::with('user')->withSum('items', 'quantity');

        if ($search) {
            $query->where('order_number', 'like', "%$search%")
                 ->orWhere('shipping_email', 'like', "%$search%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(15);

        $statusCounts = [
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'search', 'status', 'statusCounts'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'payment', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order->update($validated);
        return back()->with('success', 'Order status updated successfully');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'Order deleted successfully');
    }
}