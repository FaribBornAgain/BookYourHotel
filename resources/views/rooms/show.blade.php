<!-- File: resources/views/rooms/show.blade.php -->
@extends('layouts.master')

@section('title', $room->name . ' - BookYourHotel')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @if($room->image)
                    <img src="{{ asset('storage/' . $room->image) }}" class="img-fluid rounded shadow" alt="{{ $room->name }}">
                @else
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 400'><rect fill='%23e0e0e0' width='600' height='400'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' fill='%23999' font-size='32' font-family='Arial'>{{ $room->type }} Room</text></svg>" 
                         class="img-fluid rounded shadow" alt="{{ $room->name }}">
                @endif
            </div>
            <div class="col-md-6">
                <h2>Details</h2>
                <hr>
                <div class="mb-3">
                    <strong>Room Type:</strong> {{ ucfirst($room->type) }} Room
                </div>
                <div class="mb-3">
                    <strong>Room Facilities:</strong> {{ $room->amenities ?? 'AC, TV' }}
                </div>
                <div class="mb-3">
                    <strong>Room Capacity:</strong> {{ $room->capacity }}
                </div>
                <div class="mb-3">
                    <strong>Room Price:</strong> 
                    <span class="price-badge">TK. {{ number_format($room->price, 0, ',', '.') }}</span>
                </div>
                <div class="mb-3">
                    <strong>Seat Available:</strong> {{ $room->available_rooms }}
                </div>
                <div class="mb-4">
                    <strong>Description:</strong>
                    <p>{{ $room->description }}</p>
                </div>

                <hr>

                <h4 class="mb-3">Form Booking</h4>
                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    
                    <div class="mb-3">
                        <label class="form-label">Number of Rooms</label>
                        <input type="number" name="number_of_rooms" class="form-control" min="1" max="{{ $room->available_rooms }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="guest_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="guest_email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="guest_phone" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Check-in Date</label>
                            <input type="date" name="check_in_date" class="form-control" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Check-out Date</label>
                            <input type="date" name="check_out_date" class="form-control" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Number of Guests</label>
                        <input type="number" name="number_of_guests" class="form-control" min="1" max="{{ $room->capacity }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Special Requests (Optional)</label>
                        <textarea name="special_requests" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">FULL BOOK</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection