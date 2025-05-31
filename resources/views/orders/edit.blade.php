<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan - Sistem Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
            max-width: 900px;
            margin: 40px auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }
        .required:after {
            content: " *";
            color: #dc3545;
            font-size: 0.9rem;
        }
        .form-label {
            font-weight: 500;
            color: #444;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
            font-size: 0.95rem;
            transition: border-color 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        .form-control[readonly] {
            background-color: #f8f9fa;
            font-weight: 500;
            color: #333;
        }
        .invalid-feedback {
            font-size: 0.85rem;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .form-section {
            margin-bottom: 20px;
        }
        .alert {
            border-radius: 8px;
            font-size: 0.9rem;
        }
        .text-success {
            color: #28a745 !important;
        }
        .icon-text {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        @media (max-width: 768px) {
            .form-container {
                margin: 20px;
                padding: 20px;
            }
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1><i class="bi bi-pencil-square me-2"></i>Edit Pesanan #{{ $order->id }}</h1>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-section">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customer_id" class="form-label required">Pelanggan</label>
                            @if(auth()->user() && auth()->user()->role === 'admin')
                                <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
                                    <option value="">Pilih Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" @selected(old('customer_id', $order->customer_id) == $customer->id)>
                                            {{ $customer->name }} - {{ $customer->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @else
                                <select class="form-select" id="customer_id" name="customer_id" disabled>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" @selected($order->customer_id == $customer->id)>
                                            {{ $customer->name }} - {{ $customer->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="customer_id" value="{{ $order->customer_id }}">
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="service_id" class="form-label required">Layanan</label>
                            <select class="form-select @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                                <option value="">Pilih Layanan</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" @selected(old('service_id', $order->service_id) == $service->id) data-price="{{ $service->price_per_kg }}">
                                        {{ $service->name }} (Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}/kg)
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="weight" class="form-label required">Berat (kg)</label>
                            <input type="number" step="0.1" min="0.1" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $order->weight) }}" required>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="total_price" class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="total_price" value="Rp {{ number_format(old('total_price', $order->total_price), 0, ',', '.') }}" readonly>
                            <input type="hidden" name="total_price" id="hidden_total_price" value="{{ old('total_price', $order->total_price) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pickup_date" class="form-label required">Tanggal Pengambilan</label>
                            <input type="date" class="form-control @error('pickup_date') is-invalid @enderror" id="pickup_date" name="pickup_date" value="{{ old('pickup_date', optional($order->pickup_date)->format('Y-m-d')) }}" required>
                            @error('pickup_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                @if(auth()->user() && auth()->user()->role === 'admin')
                                    <label for="pickup_service" class="form-label">Butuh Penjemputan?</label>
                                    <select class="form-select @error('pickup_service') is-invalid @enderror" id="pickup_service" name="pickup_service" required>
                                        <option value="no" @selected(old('pickup_service', $order->pickup_service ?? 'no') == 'no')>Tidak</option>
                                        <option value="yes" @selected(old('pickup_service', $order->pickup_service) == 'yes')>Ya</option>
                                    </select>
                                    @error('pickup_service')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @else
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="pickup_service_checkbox" checked disabled>
                                        <input type="hidden" name="pickup_service" value="yes">
                                        <label class="form-check-label text-success" for="pickup_service_checkbox">
                                            <i class="bi bi-check-circle-fill me-1"></i>Penjemputan Termasuk
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="delivery_date" class="form-label required">Tanggal Pengiriman</label>
                            <input type="date" class="form-control @error('delivery_date') is-invalid @enderror" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', optional($order->delivery_date)->format('Y-m-d')) }}" required>
                            @error('delivery_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                @if(auth()->user() && auth()->user()->role === 'admin')
                                    <label for="delivery_service" class="form-label">Butuh Pengantaran?</label>
                                    <select class="form-select @error('delivery_service') is-invalid @enderror" id="delivery_service" name="delivery_service" required>
                                        <option value="no" @selected(old('delivery_service', $order->delivery_service ?? 'no') == 'no')>Tidak</option>
                                        <option value="yes" @selected(old('delivery_service', $order->delivery_service) == 'yes')>Ya</option>
                                    </select>
                                    @error('delivery_service')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @else
                                    <input type="checkbox" id="delivery_service" name="delivery_service" value="yes" checked disabled>
                                    <input type="hidden" name="delivery_service" value="yes">
                                    <label for="delivery_service" class="form-label ms-2 text-success">
                                        <i class="fas fa-check-circle me-1"></i>Pengantaran Termasuk
                                    </label>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="payment_method" class="form-label required">Metode Pembayaran</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="online" @selected(old('payment_method', $order->payment_method)==='online')>Pembayaran Online</option>
                                <option value="cash" @selected(old('payment_method', $order->payment_method)==='cash')>Bayar di Tempat</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <div class="mt-3">
                                    <label for="status" class="form-label required">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        @php $statusValue = old('status', $order->status ?? 'pending'); @endphp
                                        <option value="pending" @selected($statusValue === 'pending')>Menunggu</option>
                                        <option value="processing" @selected($statusValue === 'processing')>Sedang Diproses</option>
                                        <option value="completed" @selected($statusValue === 'completed')>Selesai</option>
                                        <option value="cancelled" @selected($statusValue === 'cancelled')>Dibatalkan</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <input type="hidden" name="status" value="{{ old('status', $order->status ?? 'pending') }}">
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="5" style="min-height: 90px; resize: vertical;" placeholder="Tambahkan instruksi khusus di sini...">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-danger">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceSelect = document.getElementById('service_id');
            const weightInput = document.getElementById('weight');
            const totalDisplay = document.getElementById('total_price');
            const hiddenTotal = document.getElementById('hidden_total_price');
            const pickupDateInput = document.getElementById('pickup_date');
            const deliveryDateInput = document.getElementById('delivery_date');

            function calculateTotal() {
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                const pricePerKg = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                const weight = parseFloat(weightInput.value) || 0;
                const total = pricePerKg * weight;
                totalDisplay.value = 'Rp ' + total.toLocaleString('id-ID');
                hiddenTotal.value = total;
            }

            // Validasi tanggal
            function validateDates() {
                const pickupDate = new Date(pickupDateInput.value);
                const deliveryDate = new Date(deliveryDateInput.value);
                
                if (deliveryDate <= pickupDate) {
                    deliveryDateInput.setCustomValidity('Tanggal pengiriman harus setelah tanggal pengambilan.');
                } else {
                    deliveryDateInput.setCustomValidity('');
                }
            }

            // Event listeners
            calculateTotal();
            serviceSelect.addEventListener('change', calculateTotal);
            weightInput.addEventListener('input', calculateTotal);
            pickupDateInput.addEventListener('change', validateDates);
            deliveryDateInput.addEventListener('change', validateDates);
        });
        </script>
    </body>
</html>
