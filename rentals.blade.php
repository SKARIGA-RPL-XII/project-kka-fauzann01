@extends('layouts.app')

@section('title', 'Rental Saya')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}"><i class="bi bi-stars text-primary"></i> Dekorasi Rental</a>
        <div class="ms-auto d-flex align-items-center">
            <a href="{{ route('user.order.status') }}" class="btn btn-outline-info me-2">
                <i class="bi bi-list-check"></i> Status Pesanan
            </a>
            <a href="{{ route('user.cart') }}" class="btn btn-outline-primary me-2 position-relative">
                <i class="bi bi-cart"></i> Keranjang
                @if($cartCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="{{ route('user.rentals') }}" class="btn btn-outline-primary me-2">
                <i class="bi bi-calendar-check"></i> Riwayat
            </a>
            <span class="me-3">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline" id="logoutForm">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h2 class="mb-4">Riwayat Rental Saya</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($rentals->count() > 0)
        <div class="row g-4">
            @foreach($rentals as $rental)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $rental->decoration->name }}</h5>
                            @if($rental->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($rental->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($rental->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-info">Completed</span>
                            @endif
                        </div>
                        
                        <div class="mb-2">
                            <i class="bi bi-calendar-event text-primary"></i>
                            <strong>Periode:</strong> {{ $rental->start_date->format('d/m/Y') }} - {{ $rental->end_date->format('d/m/Y') }}
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-box-seam text-primary"></i>
                            <strong>Jumlah:</strong> {{ $rental->quantity }} unit
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-cash-stack text-primary"></i>
                            <strong>Total Harga:</strong> Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                        </div>
                        @if($rental->notes)
                        <div class="mb-2">
                            <i class="bi bi-chat-left-text text-primary"></i>
                            <strong>Catatan:</strong> {{ $rental->notes }}
                        </div>
                        @endif
                        <div class="text-muted small">
                            <i class="bi bi-clock"></i> Dibuat: {{ $rental->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Anda belum memiliki riwayat rental. 
            <a href="{{ route('user.dashboard') }}" class="alert-link">Mulai sewa sekarang!</a>
        </div>
    @endif
</div>
@endsection
