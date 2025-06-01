@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i>Profile Saya
                    </h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @php
                        $user = auth()->user();
                        $customer = \App\Models\Customer::where('user_id', $user->id)->first();
                    @endphp

                    @if(!$customer)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Profil Pelanggan Belum Lengkap!</strong> 
                            Anda perlu melengkapi profil pelanggan untuk dapat membuat pesanan.
                        </div>
                        
                        <form action="{{ route('user.profile.complete') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Lengkapi Profil
                            </button>
                        </form>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Informasi Akun</h5>
                                <hr>
                                <p><strong>Nama:</strong> {{ $user->name }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Telepon:</strong> {{ $user->phone }}</p>
                                <p><strong>Role:</strong> 
                                    <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'primary' }}">
                                        {{ $user->isAdmin() ? 'Admin' : 'User' }}
                                    </span>
                                </p>
                            </div>
                              <div class="col-md-6">
                                <h5>Informasi Pelanggan</h5>
                                <hr>
                                <p><strong>Customer ID:</strong> #{{ $customer->id }}</p>
                                <p><strong>Alamat:</strong> 
                                    @if($customer->address)
                                        {{ $customer->address }}
                                    @else
                                        <span class="text-danger">Belum diisi</span>
                                    @endif
                                </p>
                                <p><strong>Total Pesanan:</strong> 
                                    <span class="badge bg-info">{{ $customer->orders->count() }} pesanan</span>
                                </p>
                                
                                @if(empty($customer->address))
                                    <div class="alert alert-warning mt-3">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Alamat belum diisi!</strong> Anda perlu mengisi alamat untuk dapat membuat pesanan.
                                    </div>
                                @endif
                            </div>
                        </div>                        @if(empty($customer->address))
                            <hr>
                            <div class="alert alert-info">
                                <h5><i class="fas fa-map-marker-alt me-2"></i>Lengkapi Alamat</h5>
                                <form action="{{ route('user.profile.complete') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Alamat Lengkap</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                  id="address" name="address" rows="3" required 
                                                  placeholder="Masukkan alamat lengkap Anda...">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Simpan Alamat
                                    </button>
                                </form>
                            </div>
                        @else
                            <hr>
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5><i class="fas fa-edit me-2"></i>Edit Alamat</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('user.profile.complete') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Alamat Lengkap</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                                      id="address" name="address" rows="3" required>{{ old('address', $customer->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save me-1"></i> Update Alamat
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <hr>                        
                        <!-- Navigation Buttons - Responsive Layout -->
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                            <!-- Back to Dashboard Button -->
                            <div class="order-2 order-md-1">
                                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary w-100 w-md-auto">
                                    <i class="fas fa-arrow-left me-1"></i> 
                                    <span class="d-none d-sm-inline">Kembali ke </span>Dashboard
                                </a>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="order-1 order-md-2 d-flex flex-column flex-sm-row gap-2">
                                @if(!empty($customer->address))
                                    <a href="{{ route('user.orders.create') }}" class="btn btn-success flex-fill">
                                        <i class="fas fa-plus me-1"></i> 
                                        <span class="d-none d-sm-inline">Buat </span>Pesanan<span class="d-none d-sm-inline"> Baru</span>
                                    </a>
                                @else
                                    <button class="btn btn-success flex-fill disabled" disabled title="Lengkapi alamat terlebih dahulu">
                                        <i class="fas fa-plus me-1"></i> 
                                        <span class="d-none d-sm-inline">Buat </span>Pesanan<span class="d-none d-sm-inline"> Baru</span>
                                    </button>
                                @endif
                                <a href="{{ route('user.orders') }}" class="btn btn-primary flex-fill">
                                    <i class="fas fa-list me-1"></i> 
                                    <span class="d-none d-sm-inline">Lihat </span>Pesanan<span class="d-none d-sm-inline"> Saya</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Responsive button improvements */
    @media (max-width: 576px) {
        .btn {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }
        
        .btn i {
            font-size: 0.875rem;
        }
        
        /* Stack buttons vertically on very small screens */
        .flex-fill {
            min-width: 100%;
        }
    }
    
    @media (min-width: 577px) and (max-width: 767px) {
        .btn {
            font-size: 0.9rem;
        }
        
        /* Ensure buttons don't get too cramped on medium-small screens */
        .flex-fill {
            min-width: 0;
            flex: 1;
        }
    }
    
    @media (min-width: 768px) {
        .w-md-auto {
            width: auto !important;
        }
    }
    
    /* Card responsive improvements */
    @media (max-width: 768px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .card-body {
            padding: 1.5rem 1rem;
        }
        
        .row {
            margin-left: 0;
            margin-right: 0;
        }
        
        .col-md-6 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
    }
    
    /* Alert improvements */
    @media (max-width: 576px) {
        .alert {
            font-size: 0.875rem;
            padding: 0.75rem;
        }
        
        .alert strong {
            display: block;
            margin-bottom: 0.25rem;
        }
    }
    
    /* Form improvements for mobile */
    @media (max-width: 576px) {
        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .form-control {
            font-size: 0.9rem;
        }
        
        textarea.form-control {
            min-height: 80px;
        }
    }
    
    /* Badge improvements */
    .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
    }
    
    @media (max-width: 576px) {
        .badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>
@endpush
