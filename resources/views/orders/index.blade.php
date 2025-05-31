@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <main class="col-12 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Daftar Pesanan</h1>
            </div>

            <!-- Filter Bar - Diubah struktur untuk responsif -->
            <div class="row mb-4 g-3">
                <!-- Kolom Filter dan Search -->
                <div class="col-12 col-lg-8">
                    <div class="d-flex flex-column flex-md-row gap-3">
                        <!-- Filter Dropdown -->
                        <div class="dropdown flex-shrink-0">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Filter Pesanan
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                <li>
                                    <form method="GET" action="{{ route('orders.index') }}" class="px-3 py-2">
                                        <!-- Status -->
                                        <div class="mb-2">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="">Semua</option>
                                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                            </select>
                                        </div>

                                        <!-- Tanggal -->
                                        <div class="mb-2">
                                            <label for="date_from" class="form-label">Dari Tanggal</label>
                                            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                                        </div>
                                        <div class="mb-2">
                                            <label for="date_to" class="form-label">Sampai Tanggal</label>
                                            <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                                        </div>

                                        <!-- Jenis Layanan -->
                                        <div class="mb-2">
                                            <label for="service_id" class="form-label">Jenis Layanan</label>
                                            <select name="service_id" id="service_id" class="form-select">
                                                <option value="">Semua Layanan</option>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                                        {{ $service->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Urutkan Berdasarkan ID -->
                                        <div class="mb-2">
                                            <label for="sort_id" class="form-label">Urutkan ID</label>
                                            <select name="sort_id" id="sort_id" class="form-select">
                                                <option value="">Default</option>
                                                <option value="asc" {{ request('sort_id') == 'asc' ? 'selected' : '' }}>ID Terendah (A-Z)</option>
                                                <option value="desc" {{ request('sort_id') == 'desc' ? 'selected' : '' }}>ID Tertinggi (Z-A)</option>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100 mt-3">Terapkan Filter</button>
                                    </form>
                                </li>
                            </ul>
                        </div>

                        <!-- Form Pencarian Customer -->
                        <form class="d-flex flex-grow-1" id="searchForm" method="GET" action="{{ route('orders.index') }}">
                            <input type="text" name="customer" id="customerSearch" class="form-control" placeholder="Cari nama customer..." value="{{ request('customer') }}">
                            
                            @foreach (['status', 'date_from', 'date_to', 'service_id', 'sort_id'] as $field)
                                @if(request()->has($field))
                                    <input type="hidden" name="{{ $field }}" value="{{ request($field) }}">
                                @endif
                            @endforeach

                            <button type="submit" class="btn btn-outline-primary ms-2">Cari</button>
                        </form>
                    </div>
                </div>

                <!-- Kolom Tombol Tambah -->
                <div class="col-12 col-lg-4 d-flex justify-content-start justify-content-lg-end">
                    <a href="{{ route('orders.create') }}" class="btn btn-primary w-70 w-lg-auto">
                        <i class="fas fa-plus me-1"></i> Tambah Pesanan
                    </a>
                </div>
            </div>

            <!-- Daftar Order -->
            <div class="card shadow mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center m-0" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th class="d-none d-md-table-cell">Layanan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer->name }}</td>
                                        <td class="d-none d-md-table-cell">
                                            {{ $order->service->name ?? 'N/A' }}
                                        </td>
                                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($order->status == 'completed') bg-success
                                                @elseif($order->status == 'processing') bg-warning
                                                @elseif($order->status == 'cancelled') bg-danger
                                                @else bg-secondary
                                                @endif">
                                                @switch($order->status)
                                                    @case('completed') Selesai @break
                                                    @case('processing') Sedang Diproses @break
                                                    @case('cancelled') Dibatalkan @break
                                                    @case('pending') Menunggu @break
                                                    @default {{ ucfirst($order->status) }}
                                                @endswitch
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap justify-content-center gap-1">
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                                    <i class="fas fa-eye d-none d-sm-inline"></i> <span class="d-inline d-sm-none">Lihat</span>
                                                </a>
                                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning" title="Ubah">
                                                    <i class="fas fa-edit d-none d-sm-inline"></i> <span class="d-inline d-sm-none">Ubah</span>
                                                </a>
                                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                                                        <i class="fas fa-trash d-none d-sm-inline"></i> <span class="d-inline d-sm-none">Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-3 px-3">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@section('styles')
<style>
    .container-fluid {
        padding: 0 15px;
        margin: 1rem auto;
    }

    @media (min-width: 768px) {
        .container-fluid {
            max-width: 95%;
        }
    }

    @media (min-width: 1200px) {
        .container-fluid {
            max-width: 1140px;
        }
    }

    /* Responsive table */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Button styles */
    .btn {
        white-space: nowrap;
    }

    /* Search form adjustments */
    #searchForm {
        min-width: 200px;
    }

    @media (max-width: 767.98px) {
        #searchForm {
            width: 100%;
        }
        
        .dropdown-menu {
            width: 100%;
        }
        
        /* Hide some columns on mobile */
        .d-md-table-cell {
            display: none;
        }
        
        /* Make buttons smaller on mobile */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
    }

    /* Card styles */
    .card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    /* Button hover effects */
    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Table row hover */
    .table tr:hover {
        background-color: #f1f3f5;
    }

    /* Pagination center on mobile */
    @media (max-width: 575.98px) {
        .pagination {
            justify-content: center;
        }
    }
</style>
@endsection