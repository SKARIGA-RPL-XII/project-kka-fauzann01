@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}"><i class="bi bi-stars text-primary"></i> Dekorasi Rental</a>
        <div class="ms-auto d-flex align-items-center">
            <a href="{{ route('user.order.status') }}" class="btn btn-outline-info me-2">
                <i class="bi bi-list-check"></i> Status Pesanan
            </a>
            <a href="{{ route('user.cart') }}" class="btn btn-primary me-2">
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
    <h2 class="mb-4"><i class="bi bi-cart"></i> Keranjang Belanja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($carts->count() > 0)
        <div class="row">
            <div class="col-md-8">
                @foreach($carts as $cart)
                @php
                    $days = \Carbon\Carbon::parse($cart->start_date)->diffInDays(\Carbon\Carbon::parse($cart->end_date)) + 1;
                    $subtotal = $cart->decoration->price_per_day * $cart->quantity * $days;
                @endphp
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                @if($cart->decoration->image)
                                    <img src="{{ asset('storage/' . $cart->decoration->image) }}" class="img-fluid rounded" style="height: 120px; width: 100%; object-fit: cover;">
                                @else
                                    <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded" style="height: 120px;">
                                        <i class="bi bi-image fs-1"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h5>{{ $cart->decoration->name }}</h5>
                                <p class="text-muted mb-1"><small>{{ $cart->decoration->category->name }}</small></p>
                                <p class="mb-1"><i class="bi bi-calendar-event"></i> {{ $cart->start_date->format('d/m/Y') }} - {{ $cart->end_date->format('d/m/Y') }} ({{ $days }} hari)</p>
                                <p class="mb-1"><i class="bi bi-box-seam"></i> Jumlah: {{ $cart->quantity }} unit</p>
                                @if($cart->notes)
                                <p class="mb-0 text-muted"><small><i class="bi bi-chat-left-text"></i> {{ $cart->notes }}</small></p>
                                @endif
                            </div>
                            <div class="col-md-3 text-end">
                                <h5 class="text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</h5>
                                <small class="text-muted">Rp {{ number_format($cart->decoration->price_per_day, 0, ',', '.') }}/hari</small>
                                <form method="POST" action="{{ route('user.cart.remove', $cart->id) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus dari keranjang?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-md-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Item:</span>
                            <strong>{{ $carts->count() }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Total Harga:</h5>
                            <h5 class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                        </div>
                        <form method="POST" action="{{ route('user.checkout') }}">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 btn-lg">
                                <i class="bi bi-check-circle"></i> Checkout Semua
                            </button>
                        </form>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-arrow-left"></i> Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
            <h5>Keranjang Anda Kosong</h5>
            <p>Belum ada item di keranjang. Mulai tambahkan dekorasi favorit Anda!</p>
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Lihat Katalog
            </a>
        </div>
    @endif
</div>
@endsection
