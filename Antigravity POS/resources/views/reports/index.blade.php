@extends('layouts.app')
@section('title', 'Laporan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Laporan Penjualan</h2>
        <p class="text-sm text-slate-400 mt-1">Analisis penjualan toko Anda</p>
    </div>
</div>

<!-- Date Filter -->
<div class="glass-card p-4 mb-6">
    <form method="GET" class="flex gap-3 flex-wrap items-end">
        <div>
            <label class="block text-xs text-slate-400 mb-1">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-input">
        </div>
        <div>
            <label class="block text-xs text-slate-400 mb-1">Sampai Tanggal</label>
            <input type="date" name="date_to" value="{{ $dateTo }}" class="form-input">
        </div>
        <button type="submit" class="btn btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
            Tampilkan
        </button>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="glass-card stat-card p-5" style="--gradient-from: #6366f1; --gradient-to: #8b5cf6;">
        <p class="text-xs text-slate-400 mb-1">Total Penjualan</p>
        <p class="text-xl font-bold text-slate-800">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
    </div>
    <div class="glass-card stat-card p-5" style="--gradient-from: #10b981; --gradient-to: #059669;">
        <p class="text-xs text-slate-400 mb-1">Jumlah Transaksi</p>
        <p class="text-xl font-bold text-slate-800">{{ $totalOrders }}</p>
    </div>
    <div class="glass-card stat-card p-5" style="--gradient-from: #f59e0b; --gradient-to: #d97706;">
        <p class="text-xs text-slate-400 mb-1">Total Pajak</p>
        <p class="text-xl font-bold text-slate-800">Rp {{ number_format($totalTax, 0, ',', '.') }}</p>
    </div>
    <div class="glass-card stat-card p-5" style="--gradient-from: #f43f5e; --gradient-to: #e11d48;">
        <p class="text-xs text-slate-400 mb-1">Total Diskon</p>
        <p class="text-xl font-bold text-slate-800">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Sales Chart -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Grafik Penjualan</h3>
        <canvas id="reportChart" height="160"></canvas>
    </div>

    <!-- Payment Method Breakdown -->
    <div class="glass-card p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Metode Pembayaran</h3>
        <div class="space-y-4">
            @foreach($salesByPayment as $payment)
            @php
                $percentage = $totalOrders > 0 ? ($payment->count / $totalOrders * 100) : 0;
                $colors = ['cash' => '#10b981', 'transfer' => '#6366f1', 'qris' => '#f59e0b'];
                $color = $colors[$payment->payment_method] ?? '#94a3b8';
            @endphp
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-slate-400">{{ strtoupper($payment->payment_method) }}</span>
                    <span class="text-sm text-slate-400">{{ $payment->count }} transaksi • Rp {{ number_format($payment->total, 0, ',', '.') }}</span>
                </div>
                <div class="w-full h-2 rounded-full bg-slate-100">
                    <div class="h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%; background: {{ $color }}"></div>
                </div>
            </div>
            @endforeach
            @if($salesByPayment->isEmpty())
            <p class="text-sm text-slate-400 text-center py-4">Belum ada data</p>
            @endif
        </div>
    </div>
</div>

<!-- Top Products Table -->
<div class="glass-card p-6 mt-6">
    <h3 class="text-lg font-semibold text-slate-800 mb-4">Produk Terlaris</h3>
    <table class="w-full data-table">
        <thead>
            <tr>
                <th class="text-left rounded-tl-lg">#</th>
                <th class="text-left">Produk</th>
                <th class="text-right">Qty Terjual</th>
                <th class="text-right rounded-tr-lg">Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topProducts as $i => $product)
            <tr>
                <td class="text-slate-400">{{ $i + 1 }}</td>
                <td class="font-medium text-slate-400">{{ $product->name }}</td>
                <td class="text-right text-slate-400">{{ $product->total_qty }}</td>
                <td class="text-right font-semibold text-emerald-400">Rp {{ number_format($product->total_sales, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-8 text-slate-400">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('reportChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

    const salesData = @json($salesByDay);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: salesData.map(d => d.date),
            datasets: [{
                label: 'Penjualan (Rp)',
                data: salesData.map(d => parseFloat(d.total)),
                backgroundColor: 'rgba(99, 102, 241, 0.5)',
                borderColor: '#6366f1',
                borderWidth: 1,
                borderRadius: 6,
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
                x: { grid: { color: 'rgba(51, 65, 85, 0.3)' }, ticks: { color: '#64748b' } },
                y: {
                    grid: { color: 'rgba(51, 65, 85, 0.3)' },
                    ticks: { color: '#64748b', callback: (v) => 'Rp ' + (v/1000) + 'k' }
                }
            }
        }
    });
});
</script>
@endpush
