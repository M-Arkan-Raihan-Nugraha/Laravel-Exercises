<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::active()->with('category')->orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();
        $taxEnabled = Setting::get('tax_enabled', '0') === '1';
        $taxPercentage = (float) Setting::get('tax_percentage', '11');

        return view('pos.index', compact('products', 'customers', 'taxEnabled', 'taxPercentage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,transfer,qris',
            'amount_paid' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'customer_id' => 'nullable|exists:customers,id',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$product->name} tidak mencukupi. Tersisa: {$product->stock}",
                    ], 422);
                }

                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $itemSubtotal,
                ];

                $product->decrement('stock', $item['quantity']);
            }

            $discount = (float) ($request->discount ?? 0);
            $taxEnabled = Setting::get('tax_enabled', '0') === '1';
            $taxPercentage = (float) Setting::get('tax_percentage', '11');
            $taxableAmount = $subtotal - $discount;
            $tax = $taxEnabled ? round($taxableAmount * $taxPercentage / 100) : 0;
            $total = $taxableAmount + $tax;

            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'order_number' => Order::generateOrderNumber(),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'amount_paid' => $request->amount_paid,
                'change_amount' => max(0, $request->amount_paid - $total),
                'notes' => $request->notes,
                'status' => 'completed',
            ]);

            foreach ($orderItems as $oi) {
                $order->items()->create($oi);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'order' => $order->load('items'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
