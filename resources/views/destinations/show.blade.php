@extends('layouts.master')

@section('title', $destination->name . ' Hotels - BookYourHotel')

@section('content')
<!-- Destination Header -->
<section style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ $destination->image ? asset('storage/' . $destination->image) : 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=1200' }}') center/cover; min-height: 300px; display: flex; align-items: center; color: white;">
    <div class="container">
        <h1 style="font-size: 3rem;">{{ $destination->name }}</h1>
        @if($destination->country)
            <p style="font-size: 1.3rem;">{{ $destination->country }}</p>
        @endif
        <p style="font-size: 1.1rem;">{{ $destination->hotels_count }} properties available</p>
    </div>
</section>

<!-- Hotels List -->
<section class="py-5">
    <div class="container">
        <h3 class="mb-4">Hotels in {{ $destination->name }}</h3>
        
        @if($hotels->count() > 0)
            <div class="row">
                @foreach($hotels as $hotel)
                <div class="col-md-4 mb-4">
                    <div class="card hotel-card">
                        @if($hotel->featured_image)
                            <img src="{{ asset('storage/' . $hotel->featured_image) }}" class="card-img-top" alt="{{ $hotel->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400" class="card-img-top" alt="{{ $hotel->name }}">
                        @endif
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="mb-0">{{ $hotel->name }}</h5>
                                <span class="badge bg-success">9.0</span>
                            </div>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-map-marker-alt"></i> {{ $hotel->location }}
                            </p>
                            <p class="small mb-3">{{ Str::limit($hotel->description, 100) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="text-primary mb-0">TK {{ number_format($hotel->min_price ?? 0, 0, ',', '.') }}</h5>
                                    <small class="text-muted">per night</small>
                                </div>
                                <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-primary btn-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $hotels->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No hotels available in this destination yet.
            </div>
        @endif
    </div>
</section>
@endsection