@extends('layouts.app')
@section('title', 'Pelanggan')

@section('content')
<div x-data="{ showModal: false, editMode: false, editId: null, form: { name: '', phone: '', email: '', address: '' } }">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Data Pelanggan</h2>
            <p class="text-sm text-slate-400 mt-1">Kelola pelanggan toko Anda</p>
        </div>
        <button @click="showModal = true; editMode = false; form = { name: '', phone: '', email: '', address: '' }" class="btn btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Pelanggan
        </button>
    </div>

    <div class="glass-card p-4 mb-6">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau telepon..." class="form-input flex-1">
            <button type="submit" class="btn btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Cari
            </button>
        </form>
    </div>

    <div class="glass-card overflow-hidden">
        <table class="w-full data-table">
            <thead>
                <tr>
                    <th class="text-left rounded-tl-lg">#</th>
                    <th class="text-left">Nama</th>
                    <th class="text-left">Telepon</th>
                    <th class="text-left">Email</th>
                    <th class="text-center">Total Order</th>
                    <th class="text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $i => $cust)
                <tr>
                    <td class="text-slate-400">{{ $customers->firstItem() + $i }}</td>
                    <td class="font-medium text-slate-400">{{ $cust->name }}</td>
                    <td class="text-slate-400">{{ $cust->phone ?? '-' }}</td>
                    <td class="text-slate-400">{{ $cust->email ?? '-' }}</td>
                    <td class="text-center"><span class="badge badge-info">{{ $cust->orders_count }}</span></td>
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-1">
                            <button @click="showModal = true; editMode = true; editId = {{ $cust->id }}; form = { name: '{{ addslashes($cust->name) }}', phone: '{{ $cust->phone }}', email: '{{ $cust->email }}', address: '{{ addslashes($cust->address) }}' }"
                                    class="btn btn-ghost btn-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('customers.destroy', $cust) }}" onsubmit="return confirm('Hapus pelanggan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-sm text-rose-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-slate-400">Belum ada pelanggan</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-slate-200/80">{{ $customers->withQueryString()->links() }}</div>
    </div>

    <!-- Modal -->
    <div x-show="showModal" x-transition class="fixed inset-0 z-[60] flex items-center justify-center modal-backdrop" @click.self="showModal = false">
        <div class="glass-card p-6 max-w-md w-full mx-4" @click.stop>
            <h3 class="text-lg font-bold text-slate-800 mb-4" x-text="editMode ? 'Edit Pelanggan' : 'Tambah Pelanggan'"></h3>
            <form :action="editMode ? '{{ url('customers') }}/' + editId : '{{ route('customers.store') }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Nama *</label>
                    <input type="text" name="name" x-model="form.name" class="form-input" required>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Telepon</label>
                        <input type="text" name="phone" x-model="form.phone" class="form-input">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Email</label>
                        <input type="email" name="email" x-model="form.email" class="form-input">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Alamat</label>
                    <textarea name="address" x-model="form.address" rows="2" class="form-input"></textarea>
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
