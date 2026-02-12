@extends('layouts.app')

@section('title', 'Status Pesanan')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}"><i class="bi bi-stars text-primary"></i> Dekorasi Rental</a>
        <div class="ms-auto d-flex align-items-center">
            <a href="{{ route('user.order.status') }}" class="btn btn-info me-2">
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
    <h2 class="mb-4"><i class="bi bi-list-check"></i> Status Pesanan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                <i class="bi bi-clock-history text-warning"></i> Pending <span class="badge bg-warning">{{ $pending->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#approved" type="button">
                <i class="bi bi-check-circle text-success"></i> Approved <span class="badge bg-success">{{ $approved->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#rejected" type="button">
                <i class="bi bi-x-circle text-danger"></i> Rejected <span class="badge bg-danger">{{ $rejected->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#completed" type="button">
                <i class="bi bi-check-all text-info"></i> Completed <span class="badge bg-info">{{ $completed->count() }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="pending" role="tabpanel">
            @if($pending->count() > 0)
                <div class="row g-4">
                    @foreach($pending as $rental)
                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0">{{ $rental->decoration->name }}</h5>
                                    <span class="badge bg-warning">Pending</span>
                                </div>
                                <p class="text-muted mb-2"><small>{{ $rental->decoration->category->name }}</small></p>
                                <div class="mb-2"><i class="bi bi-calendar-event text-primary"></i> {{ $rental->start_date->format('d/m/Y') }} - {{ $rental->end_date->format('d/m/Y') }}</div>
                                <div class="mb-2"><i class="bi bi-box-seam text-primary"></i> Jumlah: {{ $rental->quantity }} unit</div>
                                <div class="mb-2"><i class="bi bi-cash-stack text-primary"></i> Total: Rp {{ number_format($rental->total_price, 0, ',', '.') }}</div>
                                @if($rental->notes)
                                <div class="mb-2"><i class="bi bi-chat-left-text text-primary"></i> {{ $rental->notes }}</div>
                                @endif
                                <small class="text-muted"><i class="bi bi-clock"></i> {{ $rental->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">Tidak ada pesanan pending</div>
            @endif
        </div>

        <div class="tab-pane fade" id="approved" role="tabpanel">
            @if($approved->count() > 0)
                <div class="row g-4">
                    @foreach($approved as $rental)
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0">{{ $rental->decoration->name }}</h5>
                                    <span class="badge bg-success">Approved</span>
                                </div>
                                <p class="text-muted mb-2"><small>{{ $rental->decoration->category->name }}</small></p>
                                <div class="mb-2"><i class="bi bi-calendar-event text-primary"></i> {{ $rental->start_date->format('d/m/Y') }} - {{ $rental->end_date->format('d/m/Y') }}</div>
                                <div class="mb-2"><i class="bi bi-box-seam text-primary"></i> Jumlah: {{ $rental->quantity }} unit</div>
                                <div class="mb-2"><i class="bi bi-cash-stack text-primary"></i> Total: Rp {{ number_format($rental->total_price, 0, ',', '.') }}</div>
                                @if($rental->notes)
                                <div class="mb-2"><i class="bi bi-chat-left-text text-primary"></i> {{ $rental->notes }}</div>
                                @endif
                                <small class="text-muted"><i class="bi bi-clock"></i> {{ $rental->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">Tidak ada pesanan approved</div>
            @endif
        </div>

        <div class="tab-pane fade" id="rejected" role="tabpanel">
            @if($rejected->count() > 0)
                <div class="row g-4">
                    @foreach($rejected as $rental)
                    <div class="col-md-6">
                        <div class="card border-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0">{{ $rental->decoration->name }}</h5>
                                    <span class="badge bg-danger">Rejected</span>
                                </div>
                                <p class="text-muted mb-2"><small>{{ $rental->decoration->category->name }}</small></p>
                                <div class="mb-2"><i class="bi bi-calendar-event text-primary"></i> {{ $rental->start_date->format('d/m/Y') }} - {{ $rental->end_date->format('d/m/Y') }}</div>
                                <div class="mb-2"><i class="bi bi-box-seam text-primary"></i> Jumlah: {{ $rental->quantity }} unit</div>
                                <div class="mb-2"><i class="bi bi-cash-stack text-primary"></i> Total: Rp {{ number_format($rental->total_price, 0, ',', '.') }}</div>
                                @if($rental->notes)
                                <div class="mb-2"><i class="bi bi-chat-left-text text-primary"></i> {{ $rental->notes }}</div>
                                @endif
                                <small class="text-muted"><i class="bi bi-clock"></i> {{ $rental->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">Tidak ada pesanan rejected</div>
            @endif
        </div>

        <div class="tab-pane fade" id="completed" role="tabpanel">
            @if($completed->count() > 0)
                <div class="row g-4">
                    @foreach($completed as $rental)
                    <div class="col-md-6">
                        <div class="card border-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0">{{ $rental->decoration->name }}</h5>
                                    <span class="badge bg-info">Completed</span>
                                </div>
                                <p class="text-muted mb-2"><small>{{ $rental->decoration->category->name }}</small></p>
                                <div class="mb-2"><i class="bi bi-calendar-event text-primary"></i> {{ $rental->start_date->format('d/m/Y') }} - {{ $rental->end_date->format('d/m/Y') }}</div>
                                <div class="mb-2"><i class="bi bi-box-seam text-primary"></i> Jumlah: {{ $rental->quantity }} unit</div>
                                <div class="mb-2"><i class="bi bi-cash-stack text-primary"></i> Total: Rp {{ number_format($rental->total_price, 0, ',', '.') }}</div>
                                @if($rental->notes)
                                <div class="mb-2"><i class="bi bi-chat-left-text text-primary"></i> {{ $rental->notes }}</div>
                                @endif
                                <small class="text-muted"><i class="bi bi-clock"></i> {{ $rental->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">Tidak ada pesanan completed</div>
            @endif
        </div>
    </div>
</div>
@endsection
