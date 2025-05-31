@php
    $order = $order ?? null;
@endphp
@if(!$order || !$order->customer || !$order->service)
<div class="alert alert-danger m-3">Data pesanan tidak lengkap. Tidak dapat menampilkan struk.</div>
@else
<div class="receipt-container">
    <!-- Header -->
    <div class="receipt-header">
        <h3>LAUNDRY-IN</h3>
        <p>Struk Pesanan</p>
        <div class="receipt-divider"></div>
    </div>

    <!-- QR Code -->
    <div class="receipt-qr">
        {!! QrCode::size(80)->generate(route('orders.updateStatus', ['id' => $order->id])) !!}
        <p>ID: #{{ $order->id }}</p>
    </div>

    <!-- Order Details -->
    <div class="receipt-details">
        <div class="detail-row">
            <span>Pelanggan</span>
            <span>{{ $order->customer->name }}</span>
        </div>
        <div class="detail-row">
            <span>Layanan</span>
            <span>{{ $order->service->name }}</span>
        </div>
        <div class="detail-row">
            <span>Berat</span>
            <span>{{ $order->weight }} kg</span>
        </div>
        <div class="detail-row">
            <span>Tanggal Masuk</span>
            <span>{{ \Carbon\Carbon::parse($order->pickup_date)->format('d/m/Y') }}</span>
        </div>
        <div class="detail-row">
            <span>Tanggal Selesai</span>
            <span>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</span>
        </div>
        <div class="receipt-divider"></div>
        <div class="detail-row total">
            <span>TOTAL</span>
            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
        <div class="detail-row">
            <span>Pembayaran</span>
            <span>{{ ucfirst($order->payment_method) }}</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="receipt-footer">
        <p>Terima kasih!</p>
        <small>{{ now()->format('d/m/Y H:i') }}</small>
    </div>

    <!-- Print Button -->
    <div class="receipt-actions">
        <button class="btn-print" onclick="window.open('{{ route('orders.print', $order->id) }}', '_blank')">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>
</div>
@endif
<style>
.receipt-container {
    max-width: 350px;
    margin: 20px auto;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    padding: 25px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
}

.receipt-header {
    text-align: center;
    margin-bottom: 20px;
}

.receipt-header h3 {
    font-size: 22px;
    font-weight: bold;
    margin: 0 0 5px 0;
    color: #2c3e50;
    letter-spacing: 1px;
}

.receipt-header p {
    margin: 0;
    color: #7f8c8d;
    font-size: 14px;
}

.receipt-divider {
    height: 1px;
    background: #ecf0f1;
    margin: 15px 0;
}

.receipt-qr {
    text-align: center;
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 6px;
}

.receipt-qr p {
    margin: 10px 0 0 0;
    font-size: 14px;
    font-weight: 600;
    color: #2c3e50;
}

.receipt-details {
    margin-bottom: 20px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px dotted #ecf0f1;
    font-size: 14px;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row.total {
    font-weight: bold;
    font-size: 16px;
    color: #2c3e50;
    background: #f8f9fa;
    padding: 12px 10px;
    margin: 10px -10px;
    border-radius: 6px;
    border: none;
}

.detail-row span:first-child {
    color: #7f8c8d;
    font-weight: 500;
}

.detail-row span:last-child {
    font-weight: 600;
    color: #2c3e50;
}

.receipt-footer {
    text-align: center;
    margin-bottom: 20px;
    padding-top: 15px;
    border-top: 1px solid #ecf0f1;
}

.receipt-footer p {
    margin: 0 0 5px 0;
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
}

.receipt-footer small {
    color: #95a5a6;
    font-size: 12px;
}

.receipt-actions {
    text-align: center;
}

.btn-print {
    background: #3498db;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
}

.btn-print:hover {
    background: #2980b9;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.4);
}

.btn-print i {
    margin-right: 5px;
}

/* Print Styles */
@media print {
    .receipt-container {
        box-shadow: none;
        margin: 0;
        padding: 20px;
        max-width: none;
    }
    
    .receipt-actions {
        display: none !important;
    }
    
    .btn-print {
        display: none !important;
    }
}

/* Mobile Responsive */
@media (max-width: 480px) {
    .receipt-container {
        margin: 10px;
        padding: 20px;
    }
    
    .receipt-header h3 {
        font-size: 20px;
    }
    
    .detail-row {
        font-size: 13px;
    }
    
    .detail-row.total {
        font-size: 15px;
    }
}
</style>
<script>
    window.onload = function() {
        window.print();
    };
</script>
