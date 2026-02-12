@extends('layouts.app')

@section('title', 'Kelola Dekorasi')

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
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a class="nav-link" href="{{ route('admin.categories') }}"><i class="bi bi-tags"></i> Kategori</a>
                <a class="nav-link active" href="{{ route('admin.decorations') }}"><i class="bi bi-box-seam"></i> Dekorasi</a>
                <a class="nav-link" href="{{ route('admin.rentals') }}"><i class="bi bi-calendar-check"></i> Rental</a>
            </nav>
        </div>

        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Kelola Dekorasi</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDecorationModal">
                    <i class="bi bi-plus-circle"></i> Tambah Dekorasi
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row g-4">
                @foreach($decorations as $decoration)
                <div class="col-md-4">
                    <div class="card h-100">
                        @if($decoration->image)
                            <img src="{{ asset('storage/' . $decoration->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-image fs-1"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $decoration->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($decoration->description, 80) }}</p>
                            <div class="mb-2">
                                <span class="badge bg-info">{{ $decoration->category->name }}</span>
                                <span class="badge bg-success">Stok: {{ $decoration->stock }}</span>
                            </div>
                            <h6 class="text-primary">Rp {{ number_format($decoration->price_per_day, 0, ',', '.') }}/hari</h6>
                        </div>
                        <div class="card-footer bg-white">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $decoration->id }}">Edit</button>
                            <form method="POST" action="{{ route('admin.decorations.delete', $decoration->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editModal{{ $decoration->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Dekorasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('admin.decorations.update', $decoration->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="category_id" class="form-select" required>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $decoration->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="name" class="form-control" value="{{ $decoration->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="description" class="form-control" rows="3" required>{{ $decoration->description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Harga per Hari</label>
                                        <input type="number" name="price_per_day" class="form-control" value="{{ $decoration->price_per_day }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Stok</label>
                                        <input type="number" name="stock" class="form-control" value="{{ $decoration->stock }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Gambar</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addDecorationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dekorasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.decorations.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Dekorasi</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga per Hari (Rp)</label>
                        <input type="number" name="price_per_day" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
