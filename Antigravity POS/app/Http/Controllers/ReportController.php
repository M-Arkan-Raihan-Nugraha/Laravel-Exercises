<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->period ?? 'daily';
        $dateFrom = $request->date_from ?? Carbon::today()->format('Y-m-d');
        $dateTo = $request->date_to ?? Carbon::today()->format('Y-m-d');

        $ordersQuery = Order::where('status', 'completed')
            ->whereBetween('created_at', [
                Carbon::parse($dateFrom)->startOfDay(),
                Carbon::parse($dateTo)->endOfDay(),
            ]);

        $totalSales = (clone $ordersQuery)->sum('total');
        $totalOrders = (clone $ordersQuery)->count();
        $totalTax = (clone $ordersQuery)->sum('tax');
        $totalDiscount = (clone $ordersQuery)->sum('discount');

        // Sales by day for chart
        $salesByDay = (clone $ordersQuery)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top selling products
        $topProducts = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [
                Carbon::parse($dateFrom)->startOfDay(),
                Carbon::parse($dateTo)->endOfDay(),
            ])
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.subtotal) as total_sales')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        // Sales by payment method
        $salesByPayment = (clone $ordersQuery)
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('payment_method')
            ->get();

        return view('reports.index', compact(
            'period', 'dateFrom', 'dateTo', 'totalSales', 'totalOrders',
            'totalTax', 'totalDiscount', 'salesByDay', 'topProducts', 'salesByPayment'
        ));
    }
}
