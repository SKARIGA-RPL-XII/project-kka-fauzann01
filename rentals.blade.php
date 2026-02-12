@extends('layouts.app')

@section('title', 'Kelola Rental')

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
                <a class="nav-link" href="{{ route('admin.decorations') }}"><i class="bi bi-box-seam"></i> Dekorasi</a>
                <a class="nav-link active" href="{{ route('admin.rentals') }}"><i class="bi bi-calendar-check"></i> Rental</a>
            </nav>
        </div>

        <div class="col-md-10 p-4">
            <h2 class="mb-4">Kelola Rental</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Dekorasi</th>
                                <th>Tanggal</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentals as $rental)
                            <tr>
                                <td>{{ $rental->id }}</td>
                                <td>{{ $rental->user->name }}</td>
                                <td>{{ $rental->decoration->name }}</td>
                                <td>{{ $rental->start_date->format('d/m/Y') }} - {{ $rental->end_date->format('d/m/Y') }}</td>
                                <td>{{ $rental->quantity }}</td>
                                <td>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                                <td>
                                    @if($rental->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($rental->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($rental->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-info">Completed</span>
                                    @endif
                                </td>
                                <td>
                                    @if($rental->status == 'pending')
                                    <form method="POST" action="{{ route('admin.rentals.status', $rental->id) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.rentals.status', $rental->id) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                    @elseif($rental->status == 'approved')
                                    <form method="POST" action="{{ route('admin.rentals.status', $rental->id) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-info btn-sm">Complete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
