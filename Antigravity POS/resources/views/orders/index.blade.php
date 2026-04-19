@extends('layouts.app')
@section('title', 'Pesanan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Riwayat Pesanan</h2>
        <p class="text-sm text-slate-400 mt-1">Semua transaksi yang telah dilakukan</p>
    </div>
</div>

<!-- Filters -->
<div class="glass-card p-4 mb-6">
    <form method="GET" class="flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. order..." class="form-input flex-1 min-w-[200px]">
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input w-44">
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input w-44">
        <select name="status" class="form-input w-36">
            <option value="">Semua Status</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="btn btn-ghost">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
            Filter
        </button>
    </form>
</div>

<div class="glass-card overflow-hidden">
    <table class="w-full data-table">
        <thead>
            <tr>
                <th class="text-left rounded-tl-lg">No. Order</th>
                <th class="text-left">Tanggal</th>
                <th class="text-left">Kasir</th>
                <th class="text-left">Pelanggan</th>
                <th class="text-center">Pembayaran</th>
                <th class="text-right">Total</th>
                <th class="text-center">Status</th>
                <th class="text-center rounded-tr-lg">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td class="font-mono text-violet-400">{{ $order->order_number }}</td>
                <td class="text-slate-400">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="text-slate-400">{{ $order->user->name }}</td>
                <td class="text-slate-400">{{ $order->customer?->name ?? 'Umum' }}</td>
                <td class="text-center">
                    <span class="badge {{ $order->payment_method === 'cash' ? 'badge-success' : ($order->payment_method === 'transfer' ? 'badge-info' : 'badge-warning') }}">
                        {{ strtoupper($order->payment_method) }}
                    </span>
                </td>
                <td class="text-right font-semibold text-emerald-400">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                <td class="text-center">
                    <span class="badge {{ $order->status === 'completed' ? 'badge-success' : 'badge-danger' }}">
                        {{ $order->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
                    </span>
                </td>
                <td class="text-center">
                    <div class="flex items-center justify-center gap-1">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-ghost btn-sm" title="Detail">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="{{ route('orders.receipt', $order) }}" target="_blank" class="btn btn-ghost btn-sm" title="Cetak Struk">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-12 text-slate-400">Belum ada pesanan</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-slate-200/80">{{ $orders->withQueryString()->links() }}</div>
</div>
@endsection
