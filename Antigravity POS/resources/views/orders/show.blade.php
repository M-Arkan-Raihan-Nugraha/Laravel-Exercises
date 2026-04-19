@extends('layouts.app')
@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-sm text-slate-400 hover:text-slate-400 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Pesanan
        </a>
    </div>

    <div class="glass-card p-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $order->order_number }}</h2>
                <p class="text-sm text-slate-400 mt-1">{{ $order->created_at->format('d F Y, H:i') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="badge {{ $order->status === 'completed' ? 'badge-success' : 'badge-danger' }}">
                    {{ $order->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
                </span>
                <a href="{{ route('orders.receipt', $order) }}" target="_blank" class="btn btn-ghost btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak
                </a>
            </div>
        </div>

        <!-- Order Info -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="p-3 rounded-lg bg-slate-100/50">
                <p class="text-xs text-slate-400">Kasir</p>
                <p class="text-sm font-medium text-slate-400">{{ $order->user->name }}</p>
            </div>
            <div class="p-3 rounded-lg bg-slate-100/50">
                <p class="text-xs text-slate-400">Pelanggan</p>
                <p class="text-sm font-medium text-slate-400">{{ $order->customer?->name ?? 'Umum' }}</p>
            </div>
            <div class="p-3 rounded-lg bg-slate-100/50">
                <p class="text-xs text-slate-400">Pembayaran</p>
                <p class="text-sm font-medium text-slate-400">{{ strtoupper($order->payment_method) }}</p>
            </div>
            <div class="p-3 rounded-lg bg-slate-100/50">
                <p class="text-xs text-slate-400">Kembalian</p>
                <p class="text-sm font-medium text-emerald-400">Rp {{ number_format($order->change_amount, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Items -->
        <table class="w-full data-table mb-4">
            <thead>
                <tr>
                    <th class="text-left rounded-tl-lg">Produk</th>
                    <th class="text-right">Harga</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right rounded-tr-lg">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td class="text-slate-400">{{ $item->product_name }}</td>
                    <td class="text-right text-slate-400">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-center text-slate-400">{{ $item->quantity }}</td>
                    <td class="text-right font-medium text-emerald-400">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="border-t border-slate-200/80 pt-4 space-y-2">
            <div class="flex justify-between text-sm text-slate-400">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($order->discount > 0)
            <div class="flex justify-between text-sm text-rose-400">
                <span>Diskon</span>
                <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
            </div>
            @endif
            @if($order->tax > 0)
            <div class="flex justify-between text-sm text-slate-400">
                <span>PPN</span>
                <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between text-lg font-bold text-slate-800 pt-2 border-t border-slate-200/80">
                <span>Total</span>
                <span class="text-emerald-400">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm text-slate-400">
                <span>Dibayar</span>
                <span>Rp {{ number_format($order->amount_paid, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->notes)
        <div class="mt-4 p-3 rounded-lg bg-slate-100/50">
            <p class="text-xs text-slate-400 mb-1">Catatan</p>
            <p class="text-sm text-slate-400">{{ $order->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
