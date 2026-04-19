<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk - {{ $order->order_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; background: #f5f5f5; padding: 20px; }
        .receipt {
            max-width: 320px; margin: 0 auto; background: white; padding: 24px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-radius: 4px;
        }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .store-name { font-size: 18px; font-weight: bold; margin-bottom: 4px; }
        .divider { border-top: 1px dashed #333; margin: 10px 0; }
        .row { display: flex; justify-content: space-between; font-size: 12px; line-height: 1.6; }
        .item-name { font-size: 12px; }
        .item-detail { font-size: 11px; color: #666; display: flex; justify-content: space-between; }
        .total-row { font-size: 14px; font-weight: bold; }
        .footer { font-size: 11px; color: #666; margin-top: 16px; text-align: center; }
        @media print {
            body { padding: 0; background: white; }
            .receipt { box-shadow: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 24px; background: #6366f1; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">
            🖨️ Cetak Struk
        </button>
    </div>

    <div class="receipt">
        <div class="center">
            <div class="store-name">{{ $storeName }}</div>
            @if($storeAddress)<div style="font-size: 11px; color: #666;">{{ $storeAddress }}</div>@endif
            @if($storePhone)<div style="font-size: 11px; color: #666;">{{ $storePhone }}</div>@endif
        </div>

        <div class="divider"></div>

        <div class="row">
            <span>No: {{ $order->order_number }}</span>
        </div>
        <div class="row">
            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
            <span>{{ $order->user->name }}</span>
        </div>
        @if($order->customer)
        <div class="row">
            <span>Pelanggan: {{ $order->customer->name }}</span>
        </div>
        @endif

        <div class="divider"></div>

        @foreach($order->items as $item)
        <div class="item-name">{{ $item->product_name }}</div>
        <div class="item-detail">
            <span>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
            <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </div>
        @endforeach

        <div class="divider"></div>

        <div class="row">
            <span>Subtotal</span>
            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
        </div>
        @if($order->discount > 0)
        <div class="row">
            <span>Diskon</span>
            <span>-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
        </div>
        @endif
        @if($order->tax > 0)
        <div class="row">
            <span>PPN</span>
            <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="divider"></div>

        <div class="row total-row">
            <span>TOTAL</span>
            <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
        <div class="row">
            <span>{{ strtoupper($order->payment_method) }}</span>
            <span>Rp {{ number_format($order->amount_paid, 0, ',', '.') }}</span>
        </div>
        @if($order->change_amount > 0)
        <div class="row">
            <span>Kembalian</span>
            <span>Rp {{ number_format($order->change_amount, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="divider"></div>

        <div class="footer">
            <p>Terima kasih telah berbelanja!</p>
            <p>{{ $storeName }}</p>
        </div>
    </div>
</body>
</html>
