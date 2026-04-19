@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('products.index') }}" class="text-sm text-slate-400 hover:text-slate-400 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Produk
        </a>
    </div>

    <div class="glass-card p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Tambah Produk Baru</h2>

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
                    @error('name')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Kategori *</label>
                    <select name="category_id" class="form-input" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" class="form-input" required>
                    @error('sku')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Barcode</label>
                    <input type="text" name="barcode" value="{{ old('barcode') }}" class="form-input">
                    @error('barcode')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Harga *</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="form-input" min="0" required>
                    @error('price')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Stok *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="form-input" min="0" required>
                    @error('stock')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Batas Stok Rendah</label>
                    <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', 5) }}" class="form-input" min="0">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-400 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="form-input">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-400 mb-1">Gambar Produk</label>
                <input type="file" name="image" accept="image/*" class="form-input file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-violet-500/20 file:text-violet-400 file:text-sm file:cursor-pointer">
                @error('image')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" id="is_active" checked class="rounded bg-slate-100 border-slate-600 text-violet-500 focus:ring-violet-500">
                <label for="is_active" class="text-sm text-slate-400">Produk Aktif</label>
            </div>

            <div class="flex gap-3 pt-4 border-t border-slate-200/80">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Produk
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
