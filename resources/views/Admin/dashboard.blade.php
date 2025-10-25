@extends('layouts.master')

@section('title', 'Admin Dashboard - Hotel Hebat')

@push('styles')
<style>
    .admin-sidebar {
        background: #2c3e50;
        min-height: calc(100vh - 80px);
        padding: 20px 0;
    }
    .admin-sidebar a {
        color: white;
        padding: 12px 20px;
        display: block;
        text-decoration: none;
        transition: all 0.3s;
    }
    .admin-sidebar a:hover,
    .admin-sidebar a.active {
        background: #34495e;
        border-left: 4px solid #3498db;
    }
    .stat-card {
        border-left: 4px solid #3498db;
        transition: all 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.7;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 px-0 admin-sidebar">
            <h5 class="text-white px-3 mb-3">Admin Panel</h5>
            <a href="{{ route('admin.dashboard') }}" class="active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('admin.bookings') }}">
                <i class="fas fa-calendar-check"></i> All Bookings
            </a>
            <a href="{{ route('admin.users') }}">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="{{ route('admin.hotels') }}">
                <i class="fas fa-hotel"></i> Hotels
            </a>
            <a href="{{ route('home') }}">
                <i class="fas fa-globe"></i> View Website
            </a>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 py-4">
            <h2 class="mb-4">Dashboard Overview</h2>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Total Users</h6>
                                    <h2 class="mb-0">{{ $totalUsers }}</h2>
                                </div>
                                <i class="fas fa-users stat-icon text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card" style="border-left-color: #2ecc71;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Total Hotels</h6>
                                    <h2 class="mb-0">{{ $totalHotels }}</h2>
                                </div>
                                <i class="fas fa-hotel stat-icon text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card" style="border-left-color: #f39c12;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Total Bookings</h6>
                                    <h2 class="mb-0">{{ $totalReservations }}</h2>
                                </div>
                                <i class="fas fa-calendar-check stat-icon text-warning"></i>
                            </div>
                        </div>
                        </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card" style="border-left-color: #e74c3c;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Total Revenue</h6>
                                    <h2 class="mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                                </div>
                                <i class="fas fa-money-bill-wave stat-icon text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pending bKash Payments -->
        @if($pendingPayments->count() > 0)
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-clock"></i> Pending bKash Payments ({{ $pendingPayments->count() }})
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Reservation #</th>
                                <th>Guest</th>
                                <th>Hotel</th>
                                <th>Amount</th>
                                <th>bKash Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingPayments as $payment)
                            <tr>
                                <td><strong>{{ $payment->reservation->reservation_number }}</strong></td>
                                <td>{{ $payment->reservation->guest_name }}</td>
                                <td>{{ $payment->reservation->room->hotel->name }}</td>
                                <td><strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong></td>
                                <td>
                                    <small>
                                        <strong>Phone:</strong> {{ $payment->payment_phone }}<br>
                                        <strong>TrxID:</strong> {{ $payment->bkash_trx_id }}
                                    </small>
                                </td>
                                <td>
                                    <form action="{{ route('admin.payment.verify', $payment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Verify this payment?')">
                                            <i class="fas fa-check"></i> Verify
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Bookings -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Recent Bookings</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Reservation #</th>
                                <th>Guest</th>
                                <th>Hotel</th>
                                <th>Check-in</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBookings as $booking)
                            <tr>
                                <td><strong>{{ $booking->reservation_number }}</strong></td>
                                <td>
                                    {{ $booking->guest_name }}<br>
                                    <small class="text-muted">{{ $booking->guest_email }}</small>
                                </td>
                                <td>{{ $booking->room->hotel->name }}</td>
                                <td>{{ $booking->check_in_date->format('d M Y') }}</td>
                                <td><strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></td>
                                <td>
                                    @if($booking->payment)
                                        <span class="badge bg-info">{{ ucfirst($booking->payment->payment_method) }}</span>
                                    @else
                                        <span class="badge bg-secondary">No Payment</span>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->status == 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @elseif($booking->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($booking->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-info">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.bookings') }}" class="btn btn-outline-primary">
                        View All Bookings <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection