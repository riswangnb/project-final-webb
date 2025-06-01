@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-center fs-2 fs-md-1">Pesanan Saya</h1>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Desktop Table View -->
            <div class="d-none d-lg-block">
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="transition-row">
                                    <td>#{{ $order->id }}</td>
                                    <td>
                                        @php
                                            $status    = strtolower($order->status);
                                            $badgeMap  = [
                                                'completed'  => ['bg-success text-white', 'fa-circle-check'],
                                                'cancelled'  => ['bg-danger text-white', 'fa-circle-xmark'],
                                                'processing' => ['bg-warning text-dark', 'fa-spinner'],
                                                'pending'    => ['bg-secondary text-white', 'fa-clock'],
                                            ];
                                            $badgeClass = $badgeMap[$status][0] ?? 'bg-dark text-white';
                                            $iconClass  = $badgeMap[$status][1] ?? 'fa-question-circle';
                                        @endphp
                                        <span class="badge rounded-pill px-3 py-2 fw-medium d-inline-flex align-items-center gap-2 {{ $badgeClass }}">
                                            <i class="fas {{ $iconClass }}"></i> {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($order->total_price, 2) }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="d-lg-none">
                @forelse($orders as $order)
                    @php
                        $status    = strtolower($order->status);
                        $badgeMap  = [
                            'completed'  => ['bg-success text-white', 'fa-circle-check'],
                            'cancelled'  => ['bg-danger text-white', 'fa-circle-xmark'],
                            'processing' => ['bg-warning text-dark', 'fa-spinner'],
                            'pending'    => ['bg-secondary text-white', 'fa-clock'],
                        ];
                        $badgeClass = $badgeMap[$status][0] ?? 'bg-dark text-white';
                        $iconClass  = $badgeMap[$status][1] ?? 'fa-question-circle';
                    @endphp
                    <div class="card mb-3 shadow-sm order-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h6 class="card-title mb-0 fw-bold">Order #{{ $order->id }}</h6>
                                <span class="badge rounded-pill px-2 py-1 fw-medium d-inline-flex align-items-center gap-1 {{ $badgeClass }}">
                                    <i class="fas {{ $iconClass }}"></i>
                                    <span class="d-none d-sm-inline">{{ ucfirst($order->status) }}</span>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Total:</small>
                                    <div class="fw-medium">Rp {{ number_format($order->total_price, 2) }}</div>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted">Tanggal:</small>
                                    <div class="fw-medium">{{ $order->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>Tidak ada pesanan.</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .transition-row {
        transition: background-color 0.2s ease-in-out;
    }

    .transition-row:hover {
        background-color: #f1f1f1;
    }

    .badge i {
        font-size: 0.9rem;
    }

    .order-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }

    @media (max-width: 576px) {
        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem !important;
        }
        
        .card-body {
            padding: 1rem 0.75rem;
        }
        
        h1 {
            font-size: 1.5rem;
        }
        
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    /* Improve pagination on mobile */
    @media (max-width: 576px) {
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .pagination .page-item .page-link {
            padding: 0.375rem 0.5rem;
            font-size: 0.875rem;
        }
    }

    /* Responsive table improvements */
    @media (max-width: 991.98px) {
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>
@endpush
@endsection