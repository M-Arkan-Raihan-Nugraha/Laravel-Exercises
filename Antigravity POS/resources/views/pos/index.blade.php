@extends('layouts.app')
@section('title', 'Kasir')

@section('content')
<div x-data="posApp()" x-cloak class="flex gap-6 h-[calc(100vh-8rem)]">
    <!-- Products Grid -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Search & Filter -->
        <div class="flex gap-3 mb-4">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" x-model="search" placeholder="Cari produk atau scan barcode..." class="form-input pl-10">
            </div>
            <select x-model="categoryFilter" class="form-input w-48">
                <option value="">Semua Kategori</option>
                @foreach($products->pluck('category')->unique('id') as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Product Grid -->
        <div class="flex-1 overflow-y-auto pr-2">
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3">
                <template x-for="product in filteredProducts" :key="product.id">
                    <div @click="addToCart(product)" class="pos-product-card glass-card p-4 cursor-pointer"
                         :class="product.stock <= 0 ? 'opacity-50 pointer-events-none' : ''">
                        <div class="flex items-start justify-between mb-2">
                            <span class="badge badge-info text-xs" x-text="product.category?.name || product.category"></span>
                            <span class="text-xs" :class="product.stock <= product.low_stock_threshold ? 'text-amber-400' : 'text-slate-400'"
                                  x-text="'Stok: ' + product.stock"></span>
                        </div>
                        <h4 class="font-medium text-slate-400 text-sm mb-1 truncate" x-text="product.name"></h4>
                        <p class="text-lg font-bold text-emerald-400" x-text="formatRp(product.price)"></p>
                    </div>
                </template>
            </div>
            <div x-show="filteredProducts.length === 0" class="text-center py-12 text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <p>Produk tidak ditemukan</p>
            </div>
        </div>
    </div>

    <!-- Cart Panel -->
    <div class="w-96 flex-shrink-0 glass-card flex flex-col">
        <!-- Cart Header -->
        <div class="px-5 py-4 border-b border-slate-200/80">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    Keranjang
                </h3>
                <button @click="clearCart()" x-show="cart.length > 0" class="text-xs text-rose-400 hover:text-rose-300 transition-colors">Kosongkan</button>
            </div>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto px-5 py-3 space-y-2">
            <template x-for="(item, index) in cart" :key="item.id">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-100/50 border border-slate-200/80 group">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-400 truncate" x-text="item.name"></p>
                        <p class="text-xs text-slate-400" x-text="formatRp(item.price)"></p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button @click="updateQty(index, -1)" class="w-7 h-7 rounded-lg bg-slate-200/50 hover:bg-slate-600/50 text-slate-400 flex items-center justify-center text-sm transition-colors">−</button>
                        <input type="number" x-model.number="item.qty" @change="validateQty(index)" class="w-10 h-7 rounded-lg bg-slate-200/50 text-center text-sm text-slate-400 border-0 focus:ring-1 focus:ring-violet-500" min="1">
                        <button @click="updateQty(index, 1)" class="w-7 h-7 rounded-lg bg-slate-200/50 hover:bg-slate-600/50 text-slate-400 flex items-center justify-center text-sm transition-colors">+</button>
                    </div>
                    <p class="text-sm font-semibold text-emerald-400 w-24 text-right" x-text="formatRp(item.price * item.qty)"></p>
                    <button @click="removeFromCart(index)" class="text-slate-400 hover:text-rose-400 transition-colors opacity-0 group-hover:opacity-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </template>
            <div x-show="cart.length === 0" class="text-center py-12 text-slate-400">
                <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                <p class="text-sm">Keranjang kosong</p>
                <p class="text-xs mt-1">Klik produk untuk menambahkan</p>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="px-5 py-4 border-t border-slate-200/80 space-y-3" x-show="cart.length > 0">
            <!-- Customer -->
            <select x-model="customerId" class="form-input text-sm">
                <option value="">Pelanggan Umum</option>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>

            <!-- Discount -->
            <div class="flex items-center gap-2">
                <label class="text-xs text-slate-400 w-20">Diskon</label>
                <input type="number" x-model.number="discount" class="form-input text-sm" placeholder="0" min="0">
            </div>

            <!-- Summary -->
            <div class="space-y-2 text-sm">
                <div class="flex justify-between text-slate-400">
                    <span>Subtotal</span>
                    <span x-text="formatRp(subtotal)"></span>
                </div>
                <div class="flex justify-between text-slate-400" x-show="discount > 0">
                    <span>Diskon</span>
                    <span class="text-rose-400" x-text="'-' + formatRp(discount)"></span>
                </div>
                @if($taxEnabled)
                <div class="flex justify-between text-slate-400">
                    <span>PPN ({{ $taxPercentage }}%)</span>
                    <span x-text="formatRp(tax)"></span>
                </div>
                @endif
                <div class="flex justify-between text-lg font-bold text-slate-800 pt-2 border-t border-slate-200/80">
                    <span>Total</span>
                    <span class="text-emerald-400" x-text="formatRp(total)"></span>
                </div>
            </div>

            <!-- Payment -->
            <div class="space-y-2">
                <div class="grid grid-cols-3 gap-2">
                    <button @click="paymentMethod = 'cash'" :class="paymentMethod === 'cash' ? 'bg-violet-500/20 border-violet-500/50 text-violet-300' : 'bg-slate-100/50 border-slate-200/80 text-slate-400'"
                            class="py-2 rounded-lg border text-xs font-medium transition-all">Cash</button>
                    <button @click="paymentMethod = 'transfer'" :class="paymentMethod === 'transfer' ? 'bg-violet-500/20 border-violet-500/50 text-violet-300' : 'bg-slate-100/50 border-slate-200/80 text-slate-400'"
                            class="py-2 rounded-lg border text-xs font-medium transition-all">Transfer</button>
                    <button @click="paymentMethod = 'qris'" :class="paymentMethod === 'qris' ? 'bg-violet-500/20 border-violet-500/50 text-violet-300' : 'bg-slate-100/50 border-slate-200/80 text-slate-400'"
                            class="py-2 rounded-lg border text-xs font-medium transition-all">QRIS</button>
                </div>

                <div class="flex items-center gap-2">
                    <label class="text-xs text-slate-400 w-20">Bayar</label>
                    <input type="number" x-model.number="amountPaid" class="form-input text-sm" placeholder="0" min="0">
                </div>

                <div class="flex justify-between text-sm" x-show="amountPaid > 0 && amountPaid >= total">
                    <span class="text-slate-400">Kembalian</span>
                    <span class="font-bold text-emerald-400" x-text="formatRp(change)"></span>
                </div>
            </div>

            <button @click="processTransaction()" :disabled="processing || cart.length === 0 || amountPaid < total"
                    class="btn btn-success w-full justify-center py-3 text-base disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span x-text="processing ? 'Memproses...' : 'Bayar Sekarang'"></span>
            </button>
        </div>
    </div>

    <!-- Success Modal -->
    <div x-show="showSuccess" x-transition class="fixed inset-0 z-[60] flex items-center justify-center modal-backdrop" @click.self="showSuccess = false">
        <div class="glass-card p-8 max-w-md w-full mx-4 text-center" @click.stop>
            <div class="w-20 h-20 rounded-full bg-emerald-500/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Transaksi Berhasil!</h3>
            <p class="text-slate-400 mb-2">No. Order: <span class="text-violet-400 font-mono" x-text="lastOrder?.order_number"></span></p>
            <p class="text-2xl font-bold text-emerald-400 mb-1" x-text="formatRp(lastOrder?.total || 0)"></p>
            <p class="text-sm text-slate-400 mb-6" x-show="lastOrder?.change_amount > 0">Kembalian: <span class="text-amber-400" x-text="formatRp(lastOrder?.change_amount || 0)"></span></p>
            <div class="flex gap-3 justify-center">
                <a :href="lastOrder ? '/orders/' + lastOrder.id + '/receipt' : '#'" target="_blank" class="btn btn-ghost">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Struk
                </a>
                <button @click="showSuccess = false; resetCart()" class="btn btn-primary">Transaksi Baru</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function posApp() {
    return {
        products: @json($products),
        cart: [],
        search: '',
        categoryFilter: '',
        customerId: '',
        discount: 0,
        paymentMethod: 'cash',
        amountPaid: 0,
        processing: false,
        showSuccess: false,
        lastOrder: null,
        taxEnabled: {{ $taxEnabled ? 'true' : 'false' }},
        taxPercentage: {{ $taxPercentage }},

        get filteredProducts() {
            return this.products.filter(p => {
                const matchSearch = !this.search ||
                    p.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    (p.sku && p.sku.toLowerCase().includes(this.search.toLowerCase())) ||
                    (p.barcode && p.barcode.includes(this.search));
                const matchCat = !this.categoryFilter || p.category_id == this.categoryFilter;
                return matchSearch && matchCat;
            });
        },

        get subtotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        },

        get tax() {
            if (!this.taxEnabled) return 0;
            return Math.round((this.subtotal - this.discount) * this.taxPercentage / 100);
        },

        get total() {
            return this.subtotal - this.discount + this.tax;
        },

        get change() {
            return Math.max(0, this.amountPaid - this.total);
        },

        formatRp(val) {
            return 'Rp ' + Math.round(val).toLocaleString('id-ID');
        },

        addToCart(product) {
            const existing = this.cart.find(i => i.id === product.id);
            if (existing) {
                if (existing.qty < product.stock) existing.qty++;
            } else {
                this.cart.push({
                    id: product.id,
                    name: product.name,
                    price: parseFloat(product.price),
                    qty: 1,
                    stock: product.stock,
                    category: product.category?.name || ''
                });
            }
        },

        removeFromCart(index) { this.cart.splice(index, 1); },

        updateQty(index, delta) {
            const item = this.cart[index];
            const newQty = item.qty + delta;
            if (newQty <= 0) this.cart.splice(index, 1);
            else if (newQty <= item.stock) item.qty = newQty;
        },

        validateQty(index) {
            const item = this.cart[index];
            if (item.qty < 1) item.qty = 1;
            if (item.qty > item.stock) item.qty = item.stock;
        },

        clearCart() { if(confirm('Kosongkan keranjang?')) this.cart = []; },

        resetCart() {
            this.cart = [];
            this.discount = 0;
            this.amountPaid = 0;
            this.customerId = '';
            this.paymentMethod = 'cash';
        },

        async processTransaction() {
            if (this.cart.length === 0 || this.amountPaid < this.total) return;
            this.processing = true;

            try {
                const res = await fetch('{{ route("pos.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        items: this.cart.map(i => ({ product_id: i.id, quantity: i.qty })),
                        payment_method: this.paymentMethod,
                        amount_paid: this.amountPaid,
                        discount: this.discount,
                        customer_id: this.customerId || null,
                    })
                });

                const data = await res.json();
                if (data.success) {
                    this.lastOrder = data.order;
                    this.showSuccess = true;
                    // Update product stock locally
                    this.cart.forEach(item => {
                        const p = this.products.find(pr => pr.id === item.id);
                        if (p) p.stock -= item.qty;
                    });
                } else {
                    alert(data.message || 'Gagal memproses transaksi');
                }
            } catch (e) {
                alert('Terjadi kesalahan jaringan');
            }
            this.processing = false;
        }
    }
}
</script>
@endpush
