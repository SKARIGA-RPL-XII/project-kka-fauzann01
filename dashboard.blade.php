@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="bi bi-stars"></i> Admin Panel</a>
        <div class="ms-auto">
            <span class="text-white me-3">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline" id="logoutForm">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-3">
            <nav class="nav flex-column">
                <a class="nav-link active" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a class="nav-link" href="{{ route('admin.categories') }}"><i class="bi bi-tags"></i> Kategori</a>
                <a class="nav-link" href="{{ route('admin.decorations') }}"><i class="bi bi-box-seam"></i> Dekorasi</a>
                <a class="nav-link" href="{{ route('admin.rentals') }}"><i class="bi bi-calendar-check"></i> Rental</a>
            </nav>
        </div>

        <div class="col-md-10 p-4">
            <h2 class="mb-4">Dashboard</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50">Total Dekorasi</h6>
                                    <h2 class="mb-0">{{ $totalDecorations }}</h2>
                                </div>
                                <i class="bi bi-box-seam fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50">Total Rental</h6>
                                    <h2 class="mb-0">{{ $totalRentals }}</h2>
                                </div>
                                <i class="bi bi-calendar-check fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50">Pending</h6>
                                    <h2 class="mb-0">{{ $pendingRentals }}</h2>
                                </div>
                                <i class="bi bi-clock-history fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50">Total Pendapatan</h6>
                                    <h2 class="mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                                </div>
                                <i class="bi bi-cash-stack fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Selamat Datang, Admin!</h5>
                    <p class="card-text">Kelola sistem persewaan dekorasi Anda dengan mudah.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
