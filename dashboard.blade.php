@extends('layouts.app')

@section('title', 'Dashboard User')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 0;
        color: white;
        margin-bottom: 40px;
    }
    .search-box {
        background: white;
        border-radius: 50px;
        padding: 5px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .decoration-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
    }
    .decoration-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .decoration-img {
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s;
    }
    .decoration-card:hover .decoration-img {
        transform: scale(1.05);
    }
    .category-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 1;
    }
    .price-tag {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: bold;
    }
    .navbar-custom {
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .btn-cart {
        position: relative;
    }
    .cart-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}">
            <i class="bi bi-stars text-primary"></i> 
            <span class="text-primary">Dekorasi</span> Rental
        </a>
        <div class="ms-auto d-flex align-items-center gap-2">
            <a href="{{ route('user.order.status') }}" class="btn btn-outline-info">
                <i class="bi bi-list-check"></i> Status
            </a>
            <a href="{{ route('user.cart') }}" class="btn btn-outline-primary btn-cart">
                <i class="bi bi-cart3"></i> Keranjang
                @if($cartCount > 0)
                <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="{{ route('user.rentals') }}" class="btn btn-outline-secondary">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Temukan Dekorasi Impian Anda</h1>
        <p class="lead mb-4">Ribuan pilihan dekorasi untuk setiap momen spesial Anda</p>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="search-box">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-0" placeholder="Cari dekorasi..." id="searchInput">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-grid"></i> Katalog Dekorasi</h2>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary active" data-filter="all">Semua</button>
            @foreach($decorations->pluck('category')->unique('id') as $category)
            <button type="button" class="btn btn-outline-primary" data-filter="{{ $category->id }}">{{ $category->name }}</button>
            @endforeach
        </div>
    </div>

    <div class="row g-4" id="decorationGrid">
        @foreach($decorations as $decoration)
        <div class="col-md-4 decoration-item" data-category="{{ $decoration->category_id }}">
            <div class="card decoration-card shadow-sm">
                <div class="position-relative">
                    <span class="category-badge badge bg-dark">{{ $decoration->category->name }}</span>
                    @if($decoration->image)
                        <img src="{{ asset('storage/' . $decoration->image) }}" class="card-img-top decoration-img" alt="{{ $decoration->name }}">
                    @else
                        <div class="bg-light text-muted d-flex align-items-center justify-content-center decoration-img">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-2">{{ $decoration->name }}</h5>
                    <p class="card-text text-muted small mb-3">{{ Str::limit($decoration->description, 80) }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="price-tag">Rp {{ number_format($decoration->price_per_day, 0, ',', '.') }}/hari</span>
                        <span class="badge bg-success"><i class="bi bi-box-seam"></i> {{ $decoration->stock }}</span>
                    </div>
                    <a href="{{ route('user.decoration.show', $decoration->id) }}" class="btn btn-primary w-100">
                        <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($decorations->count() == 0)
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <h4 class="text-muted mt-3">Belum ada dekorasi tersedia</h4>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const items = document.querySelectorAll('.decoration-item');
    
    items.forEach(item => {
        const title = item.querySelector('.card-title').textContent.toLowerCase();
        const description = item.querySelector('.card-text').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || description.includes(searchTerm)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});

// Filter functionality
const filterButtons = document.querySelectorAll('[data-filter]');
filterButtons.forEach(button => {
    button.addEventListener('click', function() {
        filterButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.getAttribute('data-filter');
        const items = document.querySelectorAll('.decoration-item');
        
        items.forEach(item => {
            if (filter === 'all' || item.getAttribute('data-category') === filter) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
