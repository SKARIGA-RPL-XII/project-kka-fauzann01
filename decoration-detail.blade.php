@extends('layouts.app')

@section('title', 'Detail Dekorasi')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}"><i class="bi bi-stars text-primary"></i> Dekorasi Rental</a>
        <div class="ms-auto d-flex align-items-center">
            <a href="{{ route('user.order.status') }}" class="btn btn-outline-info me-2">
                <i class="bi bi-list-check"></i> Status Pesanan
            </a>
            <a href="{{ route('user.cart') }}" class="btn btn-outline-primary me-2">
                <i class="bi bi-cart"></i> Keranjang
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
    <div class="row">
        <div class="col-md-6">
            @if($decoration->image)
                <img src="{{ asset('storage/' . $decoration->image) }}" class="img-fluid rounded shadow" style="width: 100%; height: 400px; object-fit: cover;">
            @else
                <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                    <i class="bi bi-image" style="font-size: 100px;"></i>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <span class="badge bg-info mb-2">{{ $decoration->category->name }}</span>
            <h2 class="mb-3">{{ $decoration->name }}</h2>
            <p class="text-muted">{{ $decoration->description }}</p>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="text-primary">Rp {{ number_format($decoration->price_per_day, 0, ',', '.') }} <small class="text-muted">/hari</small></h4>
                    <p class="mb-0"><i class="bi bi-box-seam"></i> Stok Tersedia: <strong>{{ $decoration->stock }}</strong></p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Pemesanan</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.decoration.rent', $decoration->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="quantity" class="form-control" min="1" max="{{ $decoration->stock }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            <i class="bi bi-cart-check"></i> Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
