<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ $order->id }} - LAUNDRY-IN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .print-container {
            max-width: 400px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .receipt-content {
            padding: 30px;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }

        .receipt-header h1 {
            font-size: 28px;
            font-weight: bold;
            margin: 0 0 8px 0;
            color: #2c3e50;
            letter-spacing: 2px;
        }

        .receipt-header p {
            margin: 0;
            color: #6c757d;
            font-size: 16px;
            font-weight: 500;
        }

        .receipt-qr {
            text-align: center;
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .receipt-qr svg {
            border: 2px solid #dee2e6;
            border-radius: 6px;
            padding: 8px;
            background: white;
        }

        .receipt-qr p {
            margin: 15px 0 0 0;
            font-size: 16px;
            font-weight: 700;
            color: #495057;
        }

        .receipt-details {
            margin-bottom: 25px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dotted #dee2e6;
            font-size: 15px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row span:first-child {
            font-weight: 500;
            color: #6c757d;
            flex: 1;
        }

        .detail-row span:last-child {
            font-weight: 600;
            color: #343a40;
            text-align: right;
            max-width: 200px;
            word-wrap: break-word;
        }

        .detail-row.total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #28a745;
            border-bottom: 2px solid #28a745;
            background: #f8fff9;
            border-radius: 6px;
            padding: 15px 12px;
            font-size: 18px;
        }

        .detail-row.total span {
            color: #28a745;
            font-weight: bold;
        }

        .receipt-footer {
            text-align: center;
            margin-bottom: 25px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .receipt-footer p {
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: 600;
            color: #28a745;
        }

        .receipt-footer small {
            color: #6c757d;
            font-size: 13px;
        }

        .print-actions {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 8px;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .btn-print {
            background: #007bff;
            color: white;
        }

        .btn-print:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-close {
            background: #6c757d;
            color: white;
        }

        .btn-close:hover {
            background: #545b62;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn i {
            margin-right: 8px;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
            }

            .print-container {
                margin: 0;
                box-shadow: none;
                border-radius: 0;
                max-width: none;
            }

            .print-actions {
                display: none !important;
            }

            .receipt-content {
                padding: 20px;
            }

            .receipt-header h1 {
                font-size: 24px;
            }

            .detail-row {
                font-size: 14px;
            }

            .detail-row.total {
                font-size: 16px;
            }
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            .print-container {
                margin: 20px;
                border-radius: 8px;
            }

            .receipt-content {
                padding: 20px;
            }

            .receipt-header h1 {
                font-size: 24px;
                letter-spacing: 1px;
            }

            .detail-row {
                font-size: 14px;
                padding: 10px 0;
            }

            .detail-row.total {
                font-size: 16px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 13px;
                margin: 5px;
                display: block;
                width: 100%;
                max-width: 200px;
                margin: 5px auto;
            }
        }

        /* Animation for smooth loading */
        .print-container {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <div class="receipt-content">
            <!-- Header -->
            <div class="receipt-header">
                <h1>LAUNDRY-IN</h1>
                <p>Struk Pesanan</p>
            </div>

            <!-- QR Code -->
            <div class="receipt-qr">
                {!! QrCode::size(100)->generate(route('orders.updateStatus', ['id' => $order->id])) !!}
                <p>ID: #{{ $order->id }}</p>
            </div>

            <!-- Order Details -->
            <div class="receipt-details">
                <div class="detail-row">
                    <span>Pelanggan</span>
                    <span>{{ $order->customer->name }}</span>
                </div>
                <div class="detail-row">
                    <span>Telepon</span>
                    <span>{{ $order->customer->phone }}</span>
                </div>
                <div class="detail-row">
                    <span>Alamat</span>
                    <span>{{ $order->customer->address }}</span>
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
                    <span>Harga per kg</span>
                    <span>Rp {{ number_format($order->service->price_per_kg, 0, ',', '.') }}</span>
                </div>
                <div class="detail-row">
                    <span>Tanggal Masuk</span>
                    <span>{{ \Carbon\Carbon::parse($order->pickup_date)->format('d/m/Y') }}</span>
                </div>
                <div class="detail-row">
                    <span>Tanggal Selesai</span>
                    <span>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</span>
                </div>
                <div class="detail-row">
                    <span>Pembayaran</span>
                    <span>{{ ucfirst($order->payment_method) }}</span>
                </div>
                @if($order->pickup_service === 'yes')
                <div class="detail-row">
                    <span>Layanan Jemput</span>
                    <span>✓ Ya</span>
                </div>
                @endif
                @if($order->delivery_service === 'yes')
                <div class="detail-row">
                    <span>Layanan Antar</span>
                    <span>✓ Ya</span>
                </div>
                @endif
                <div class="detail-row total">
                    <span>TOTAL BAYAR</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Footer -->
            <div class="receipt-footer">
                <p>Terima kasih!</p>
                <small>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</small>
            </div>
        </div>

        <!-- Print Actions -->
        <div class="print-actions">
            <button class="btn btn-print" onclick="window.print()">
                <i class="bi bi-printer"></i>Cetak Struk
            </button>
            <button class="btn btn-close" onclick="window.close()">
                <i class="bi bi-x-circle"></i>Tutup
            </button>
        </div>
    </div>

    <script>
        // Auto focus for better UX
        document.addEventListener('DOMContentLoaded', function() {
            // Focus on print button for keyboard navigation
            document.querySelector('.btn-print').focus();
            
            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl+P or Cmd+P for print
                if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                    e.preventDefault();
                    window.print();
                }
                // Escape to close
                if (e.key === 'Escape') {
                    window.close();
                }
            });
            
            // Print completion callback
            window.addEventListener('afterprint', function() {
                // Optional: Show confirmation or auto-close
                // setTimeout(() => window.close(), 2000);
            });
        });
    </script>
</body>
</html>
