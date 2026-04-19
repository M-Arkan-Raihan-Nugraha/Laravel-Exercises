@extends('layouts.app')
@section('title', 'Produk')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Daftar Produk</h2>
        <p class="text-sm text-slate-400 mt-1">Kelola semua produk toko Anda</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Tambah Produk
    </a>
</div>

<!-- Filters -->
<div class="glass-card p-4 mb-6">
    <form method="GET" class="flex gap-3 flex-wrap">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, SKU, barcode..." class="form-input">
        </div>
        <select name="category" class="form-input w-48">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="stock" class="form-input w-40">
            <option value="">Semua Stok</option>
            <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Stok Rendah</option>
        </select>
        <button type="submit" class="btn btn-ghost">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Cari
        </button>
    </form>
</div>

<!-- Products Table -->
<div class="glass-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left rounded-tl-lg">Produk</th>
                    <th class="text-left">Kategori</th>
                    <th class="text-left">SKU</th>
                    <th class="text-right">Harga</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Status</th>
                    <th class="text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-slate-400">{{ $product->name }}</p>
                                @if($product->barcode)<p class="text-xs text-slate-400">{{ $product->barcode }}</p>@endif
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-info">{{ $product->category->name }}</span></td>
                    <td class="font-mono text-slate-400">{{ $product->sku }}</td>
                    <td class="text-right font-semibold text-emerald-400">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <span class="badge {{ $product->isLowStock() ? 'badge-warning' : 'badge-success' }}">{{ $product->stock }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-ghost btn-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-sm text-rose-400 hover:text-rose-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-slate-400">Belum ada produk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-200/80">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
