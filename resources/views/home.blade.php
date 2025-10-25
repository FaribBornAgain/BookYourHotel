<!-- File: resources/views/home.blade.php -->
@extends('layouts.master')

@section('title', 'Hotel Hebat - Away from monotonous life')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <p class="text-uppercase" style="letter-spacing: 3px; margin-bottom: 10px;">AWAY FROM MONOTONOUS LIFE</p>
        <h1>Hotel Hebat</h1>
        <p>Hotel bersih, aman, nyaman, sehat<br>Harga yang terjangkau, pelayanan memuaskan</p>
        <a href="#rooms" class="btn btn-primary btn-lg">GET STARTED</a>
    </div>
</section>

<!-- Search Availability Section -->
<section class="py-5" style="background-color: var(--light-bg);">
    <div class="container">
        <div class="card p-4">
            <h3 class="text-center mb-4">Check Room Availability</h3>
            <form action="{{ route('rooms.checkAvailability') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Check-in Date</label>
                        <input type="date" name="check_in" class="form-control" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Check-out Date</label>
                        <input type="date" name="check_out" class="form-control" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Guests</label>
                        <input type="number" name="guests" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Rooms</label>
                        <input type="number" name="rooms" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Enjoy Your Section -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="mb-5">ENJOY YOUR VACATION</h2>
        <p class="lead mb-5" style="max-width: 800px; margin: 0 auto;">
            Experience the perfect blend of comfort and luxury at Hotel Hebat. 
            Our carefully designed rooms and exceptional service ensure your stay is memorable.
        </p>
    </div>
</section>

<!-- Hotel Types Section -->
<section class="py-5" style="background-color: var(--light-bg);" id="rooms">
    <div class="container">
        <h2 class="text-center mb-5">Hotel Types</h2>
        <div class="row">
            @foreach($rooms as $room)
            <div class="col-md-4">
                <div class="card">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top" alt="{{ $room->name }}">
                    @else
                        <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 250'><rect fill='%23e0e0e0' width='400' height='250'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' fill='%23999' font-size='24' font-family='Arial'>{{ $room->type }} Room</text></svg>" class="card-img-top" alt="{{ $room->name }}">
                    @endif
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $room->name }}</h5>
                        <p class="price-badge mb-3">Rp. {{ number_format($room->price, 0, ',', '.') }}/night</p>
                        <p class="text-muted small">Kamar Tersedia: {{ $room->available_rooms }}</p>
                        <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-primary">BOOK NOW</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 text-center" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
    <div class="container">
        <h2 class="mb-4">Ready to Book Your Stay?</h2>
        <p class="lead mb-4">Experience comfort and luxury at Hotel Hebat</p>
        <a href="#rooms" class="btn btn-light btn-lg">BOOK NOW</a>
    </div>
</section>
@endsection