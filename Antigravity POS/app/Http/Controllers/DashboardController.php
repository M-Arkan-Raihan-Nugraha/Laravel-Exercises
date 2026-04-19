<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        // Today's stats
        $todaySales = Order::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total');

        $todayOrders = Order::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        $monthSales = Order::whereBetween('created_at', [$startOfMonth, Carbon::now()])
            ->where('status', 'completed')
            ->sum('total');

        $totalProducts = Product::count();
        $lowStockProducts = Product::lowStock()->get();

        // Top products this month
        $topProducts = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startOfMonth, Carbon::now()])
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_qty'), DB::raw('SUM(order_items.subtotal) as total_sales'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // Sales chart data (last 7 days)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = (float) Order::whereDate('created_at', $date)
                ->where('status', 'completed')
                ->sum('total');
        }

        // Recent orders
        $recentOrders = Order::with(['user', 'customer'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'todaySales', 'todayOrders', 'monthSales', 'totalProducts',
            'lowStockProducts', 'topProducts', 'chartLabels', 'chartData', 'recentOrders'
        ));
    }
}
