@extends('layouts.master')

@section('title', 'Hotel Hebat - Book Hotels & Accommodations')

@push('styles')
<style>
    /* Hero Search Section */
    .hero-search {
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                    url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200') center/cover;
        min-height: 400px;
        display: flex;
        align-items: center;
        color: white;
        padding: 80px 0 60px;
    }

    .hero-search h1 {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .hero-search p {
        font-size: 1.5rem;
        margin-bottom: 30px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    .search-box {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .search-box .form-control {
        height: 50px;
        font-size: 1rem;
        border: 2px solid #ddd;
    }

    .search-box .btn-search {
        height: 50px;
        font-size: 1.1rem;
        font-weight: bold;
    }

    /* Why Choose Section */
    .why-choose {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .why-choose .feature-box {
        text-align: center;
        padding: 30px;
        background: white;
        border-radius: 10px;
        margin-bottom: 20px;
        transition: all 0.3s;
    }

    .why-choose .feature-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .why-choose .feature-box i {
        font-size: 3rem;
        color: #003580;
        margin-bottom: 15px;
    }

    /* Trending Destinations */
    .trending-destinations {
        padding: 60px 0;
    }

    .destination-card {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        height: 300px;
        margin-bottom: 30px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .destination-card:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }

    .destination-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .destination-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        padding: 30px 20px;
        color: white;
    }

    .destination-overlay h3 {
        font-size: 1.8rem;
        margin-bottom: 5px;
    }

    .destination-overlay p {
        margin: 0;
        opacity: 0.9;
    }

    /* Property Types */
    .property-types {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .property-card {
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 30px;
        transition: all 0.3s;
        cursor: pointer;
    }

    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .property-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .property-card .card-body {
        padding: 20px;
    }

    .property-card h5 {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    /* Featured Hotels */
    .featured-hotels {
        padding: 60px 0;
    }

    .hotel-card {
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 30px;
        transition: all 0.3s;
        border: 1px solid #e0e0e0;
    }

    .hotel-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border-color: #003580;
    }

    .hotel-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .hotel-card .badge-rating {
        background: #003580;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    .hotel-card .price {
        font-size: 1.5rem;
        color: #003580;
        font-weight: bold;
    }

    /* Special Offers Banner */
    .special-offers {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 0;
        color: white;
        text-align: center;
    }

    .special-offers h2 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    /* Newsletter */
    .newsletter {
        background: #003580;
        padding: 60px 0;
        color: white;
    }

    .newsletter h3 {
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .newsletter .form-control {
        height: 50px;
        border-radius: 5px 0 0 5px;
    }

    .newsletter .btn {
        height: 50px;
        border-radius: 0 5px 5px 0;
    }

    /* Section Titles */
    .section-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 40px;
        color: #1a1a1a;
    }

    .section-subtitle {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 40px;
    }
</style>
@endpush

@section('content')

<!-- Hero Search Section -->
<section class="hero-search">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1>Find your next stay</h1>
                <p>Search deals on hotels, homes, and much more...</p>
            </div>
        </div>
        
        <!-- Search Box -->
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="search-box">
                    <form action="{{ route('rooms.checkAvailability') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small"><i class="fas fa-map-marker-alt"></i> Destination</label>
                                <input type="text" class="form-control" name="destination" placeholder="Where are you going?" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small"><i class="fas fa-calendar"></i> Check-in</label>
                                <input type="date" class="form-control" name="check_in" required min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small"><i class="fas fa-calendar"></i> Check-out</label>
                                <input type="date" class="form-control" name="check_out" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small"><i class="fas fa-user"></i> Guests</label>
                                <input type="number" class="form-control" name="guests" value="2" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small"><i class="fas fa-door-open"></i> Rooms</label>
                                <input type="number" class="form-control" name="rooms" value="1" min="1" required>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label small">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100 btn-search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="why-choose">
    <div class="container">
        <h2 class="section-title text-center">Why book with Hotel Hebat?</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="feature-box">
                    <i class="fas fa-tags"></i>
                    <h5>Best Price Guarantee</h5>
                    <p>Find the best deals for your stay</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-box">
                    <i class="fas fa-shield-alt"></i>
                    <h5>Safe & Secure</h5>
                    <p>Your payment is protected</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-box">
                    <i class="fas fa-headset"></i>
                    <h5>24/7 Support</h5>
                    <p>We're here to help anytime</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-box">
                    <i class="fas fa-star"></i>
                    <h5>Best Selection</h5>
                    <p>Over {{ $totalHotels ?? 0 }}+ hotels worldwide</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trending Destinations -->
@if(isset($destinations) && $destinations->count() > 0)
<section class="trending-destinations">
    <div class="container">
        <h2 class="section-title">Trending destinations</h2>
        <p class="section-subtitle">Most popular choices for travelers from Bangladesh</p>
        
        <div class="row">
            @foreach($destinations->take(6) as $destination)
            <div class="col-md-4">
                <a href="{{ route('destination.show', $destination->id) }}" class="text-decoration-none">
                    <div class="destination-card">
                        @if($destination->image)
                            <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=600" alt="{{ $destination->name }}">
                        @endif
                        <div class="destination-overlay">
                            <h3>{{ $destination->name }}</h3>
                            <p>{{ $destination->hotels_count }} properties</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Browse by Property Type -->
@if(isset($propertyTypes) && $propertyTypes->count() > 0)
<section class="property-types">
    <div class="container">
        <h2 class="section-title">Browse by property type</h2>
        
        <div class="row">
            @foreach($propertyTypes as $type)
            <div class="col-md-3">
                <a href="{{ route('property-type.show', $type->id) }}" class="text-decoration-none">
                    <div class="card property-card">
                        @if($type->image)
                            <img src="{{ asset('storage/' . $type->image) }}" alt="{{ $type->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400" alt="{{ $type->name }}">
                        @endif
                        <div class="card-body">
                            <h5>{{ $type->name }}</h5>
                            <p class="text-muted mb-0">{{ $type->hotels->count() }} properties</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Hotels -->
<section class="featured-hotels">
    <div class="container">
        <h2 class="section-title">Homes guests love</h2>
        
        <div class="row">
            @if(isset($hotels) && $hotels->count() > 0)
                @foreach($hotels->take(8) as $hotel)
                <div class="col-md-3">
                    <div class="card hotel-card">
                        @if($hotel->featured_image)
                            <img src="{{ asset('storage/' . $hotel->featured_image) }}" alt="{{ $hotel->name }}">
                        @elseif($hotel->image)
                            <img src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400" alt="{{ $hotel->name }}">
                        @endif
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="mb-0">{{ $hotel->name }}</h5>
                                <span class="badge-rating">9.2</span>
                            </div>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-map-marker-alt"></i> {{ $hotel->location }}
                            </p>
                            <p class="text-muted small mb-3">{{ Str::limit($hotel->description, 80) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price">Rp {{ number_format($hotel->min_price ?? 200000, 0, ',', '.') }}</span>
                                    <small class="text-muted d-block">per night</small>
                                </div>
                                <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-primary btn-sm">
                                    See availability
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Default rooms if no hotels -->
                @foreach($rooms->take(8) as $room)
                <div class="col-md-3">
                    <div class="card hotel-card">
                        @if($room->featured_image)
                            <img src="{{ asset('storage/' . $room->featured_image) }}" alt="{{ $room->name }}">
                        @elseif($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}">
                        @else
                            <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 250'><rect fill='%23e0e0e0' width='400' height='250'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' fill='%23999' font-size='24' font-family='Arial'>{{ $room->type }} Room</text></svg>" alt="{{ $room->name }}">
                        @endif
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="mb-0">{{ $room->name }}</h5>
                                <span class="badge-rating">8.9</span>
                            </div>
                            <p class="text-muted small mb-2">
                                <span class="badge bg-info">{{ ucfirst($room->type) }}</span>
                            </p>
                            <p class="text-muted small mb-3">{{ Str::limit($room->description, 80) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                                    <small class="text-muted d-block">per night</small>
                                </div>
                                <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-primary btn-sm">
                                    See availability
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Special Offers Banner -->
<section class="special-offers">
    <div class="container">
        <h2>Get instant discounts</h2>
        <p class="lead mb-4">Simply sign in and save up to 15% on thousands of stays</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
            <i class="fas fa-user-plus"></i> Sign Up Free
        </a>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3>Get exclusive deals in your inbox</h3>
                <p>Subscribe to see secret deals prices drop the moment you sign up!</p>
            </div>
            <div class="col-md-6">
                <form class="d-flex">
                    <input type="email" class="form-control" placeholder="Your email address" required>
                    <button type="submit" class="btn btn-warning">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection