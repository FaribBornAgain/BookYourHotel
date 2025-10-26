<!-- File: resources/views/reservations/my-reservations.blade.php -->
@extends('layouts.master')

@section('title', 'My Reservations - BookYourHotel')

@section('content')
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Your Dashboard</h2>

        @if(auth()->check() && isset($reservations) && $reservations->count() > 0)
            <!-- Show reservations if user is logged in and has bookings -->
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Reservation #</th>
                                <th>Hotel Type</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Room Type</th>
                                <th>Total Guest</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td><strong>{{ $reservation->reservation_number }}</strong></td>
                                <td>{{ $reservation->room->name }}</td>
                                <td>{{ $reservation->check_in_date->format('d M Y') }}</td>
                                <td>{{ $reservation->check_out_date->format('d M Y') }}</td>
                                <td>{{ $reservation->number_of_rooms }}</td>
                                <td><strong>Rp. {{ number_format($reservation->total_price, 0, ',', '.') }}</strong></td>
                                <td>
                                    @if($reservation->status == 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @elseif($reservation->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($reservation->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-info">{{ ucfirst($reservation->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if($reservation->status != 'cancelled' && $reservation->status != 'completed')
                                    <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this reservation?')">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Empty state -->
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Hotel Type</th>
                                <th>Room Type</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Total Guest</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    @auth
                                        <p>You don't have any reservations yet</p>
                                        <a href="{{ route('home') }}" class="btn btn-primary">Browse Rooms</a>
                                    @else
                                        <p>Please login to view your reservations</p>
                                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Browse as Guest</a>
                                    @endauth
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if(!auth()->check())
        <div class="text-center mt-4">
            <p class="text-muted">
                Have a reservation number? 
                <a href="#" data-bs-toggle="modal" data-bs-target="#searchModal">Search by reservation number</a>
            </p>
        </div>
        @endif
    </div>
</section>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transactions.searchByNumber') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Reservation Number</label>
                        <input type="text" name="reservation_number" class="form-control" placeholder="RES-XXXXXX" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection