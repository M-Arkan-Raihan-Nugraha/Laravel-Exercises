@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass-card stat-card p-6 animate-fade-in-up" style="--gradient-from: #6366f1; --gradient-to: #8b5cf6;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-400 mb-1">Penjualan Hari Ini</p>
                <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($todaySales, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-violet-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="glass-card stat-card p-6 animate-fade-in-up animate-delay-100" style="--gradient-from: #10b981; --gradient-to: #059669;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-400 mb-1">Transaksi Hari Ini</p>
                <p class="text-2xl font-bold text-slate-800">{{ $todayOrders }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
    </div>

    <div class="glass-card stat-card p-6 animate-fade-in-up animate-delay-200" style="--gradient-from: #f59e0b; --gradient-to: #d97706;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-400 mb-1">Penjualan Bulan Ini</p>
                <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($monthSales, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
    </div>

    <div class="glass-card stat-card p-6 animate-fade-in-up animate-delay-300" style="--gradient-from: #f43f5e; --gradient-to: #e11d48;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-400 mb-1">Total Produk</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalProducts }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Sales Chart -->
    <div class="lg:col-span-2 glass-card p-6 animate-fade-in-up animate-delay-400">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Tren Penjualan (7 Hari Terakhir)</h3>
        <canvas id="salesChart" height="120"></canvas>
    </div>

    <!-- Top Products -->
    <div class="glass-card p-6 animate-fade-in-up animate-delay-400">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Produk Terlaris</h3>
        <div class="space-y-3">
            @forelse($topProducts as $i => $product)
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-500/20 to-indigo-500/20 flex items-center justify-center text-sm font-bold text-violet-400">
                    {{ $i + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-400 truncate">{{ $product->name }}</p>
                    <p class="text-xs text-slate-400">{{ $product->total_qty }} terjual</p>
                </div>
                <p class="text-sm font-semibold text-emerald-400">Rp {{ number_format($product->total_sales, 0, ',', '.') }}</p>
            </div>
            @empty
            <p class="text-sm text-slate-400 text-center py-4">Belum ada data penjualan</p>
            @endforelse
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- Recent Orders -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Pesanan Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full data-table">
                <thead>
                    <tr>
                        <th class="text-left rounded-tl-lg">No. Order</th>
                        <th class="text-left">Kasir</th>
                        <th class="text-right">Total</th>
                        <th class="text-center rounded-tr-lg">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="font-mono text-violet-400">{{ $order->order_number }}</td>
                        <td class="text-slate-400">{{ $order->user->name }}</td>
                        <td class="text-right text-emerald-400 font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="badge {{ $order->status === 'completed' ? 'badge-success' : 'badge-danger' }}">
                                {{ $order->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-slate-400 py-8">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            Stok Rendah
        </h3>
        <div class="space-y-3">
            @forelse($lowStockProducts as $product)
            <div class="flex items-center justify-between p-3 rounded-lg bg-amber-500/5 border border-amber-500/10">
                <div>
                    <p class="text-sm font-medium text-slate-400">{{ $product->name }}</p>
                    <p class="text-xs text-slate-400">SKU: {{ $product->sku }}</p>
                </div>
                <span class="badge badge-warning">Sisa: {{ $product->stock }}</span>
            </div>
            @empty
            <p class="text-sm text-slate-400 text-center py-4">Semua stok aman 👍</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Penjualan (Rp)',
                data: @json($chartData),
                borderColor: '#6366f1',
                backgroundColor: gradient,
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#1e1b4b',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#e2e8f0',
                    bodyColor: '#94a3b8',
                    borderColor: '#334155',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: (ctx) => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(51, 65, 85, 0.3)', drawBorder: false },
                    ticks: { color: '#64748b' }
                },
                y: {
                    grid: { color: 'rgba(51, 65, 85, 0.3)', drawBorder: false },
                    ticks: {
                        color: '#64748b',
                        callback: (v) => 'Rp ' + (v/1000) + 'k'
                    }
                }
            }
        }
    });
});
</script>
@endpush
