@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
<div x-data="{ showModal: false, editMode: false, editId: null, formName: '', formDesc: '' }">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Kategori Produk</h2>
            <p class="text-sm text-slate-400 mt-1">Kelola kategori untuk produk Anda</p>
        </div>
        <button @click="showModal = true; editMode = false; formName = ''; formDesc = ''" class="btn btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Kategori
        </button>
    </div>

    <!-- Search -->
    <div class="glass-card p-4 mb-6">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..." class="form-input flex-1">
            <button type="submit" class="btn btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Cari
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="glass-card overflow-hidden">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left rounded-tl-lg">#</th>
                    <th class="text-left">Nama</th>
                    <th class="text-left">Deskripsi</th>
                    <th class="text-center">Jumlah Produk</th>
                    <th class="text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $i => $cat)
                <tr>
                    <td class="text-slate-400">{{ $categories->firstItem() + $i }}</td>
                    <td class="font-medium text-slate-400">{{ $cat->name }}</td>
                    <td class="text-slate-400">{{ $cat->description ?? '-' }}</td>
                    <td class="text-center"><span class="badge badge-info">{{ $cat->products_count }}</span></td>
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-1">
                            <button @click="showModal = true; editMode = true; editId = {{ $cat->id }}; formName = '{{ addslashes($cat->name) }}'; formDesc = '{{ addslashes($cat->description) }}'"
                                    class="btn btn-ghost btn-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('categories.destroy', $cat) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-sm text-rose-400 hover:text-rose-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-12 text-slate-400">Belum ada kategori</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-slate-200/80">{{ $categories->withQueryString()->links() }}</div>
    </div>

    <!-- Modal -->
    <div x-show="showModal" x-transition class="fixed inset-0 z-[60] flex items-center justify-center modal-backdrop" @click.self="showModal = false">
        <div class="glass-card p-6 max-w-md w-full mx-4" @click.stop>
            <h3 class="text-lg font-bold text-slate-800 mb-4" x-text="editMode ? 'Edit Kategori' : 'Tambah Kategori'"></h3>
            <form :action="editMode ? '{{ url('categories') }}/' + editId : '{{ route('categories.store') }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Nama *</label>
                    <input type="text" name="name" x-model="formName" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Deskripsi</label>
                    <textarea name="description" x-model="formDesc" rows="3" class="form-input"></textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" @click="showModal = false" class="btn btn-ghost">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
