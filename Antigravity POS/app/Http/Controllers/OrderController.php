<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'customer'])
            ->when($request->search, fn($q) => $q->where('order_number', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user', 'customer']);
        $storeName = Setting::get('store_name', 'Antigravity POS');
        $storeAddress = Setting::get('store_address', '');
        $storePhone = Setting::get('store_phone', '');

        return view('orders.show', compact('order', 'storeName', 'storeAddress', 'storePhone'));
    }

    public function receipt(Order $order)
    {
        $order->load(['items', 'user', 'customer']);
        $storeName = Setting::get('store_name', 'Antigravity POS');
        $storeAddress = Setting::get('store_address', '');
        $storePhone = Setting::get('store_phone', '');

        return view('orders.receipt', compact('order', 'storeName', 'storeAddress', 'storePhone'));
    }
}
