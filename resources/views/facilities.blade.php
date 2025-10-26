<!-- File: resources/views/facilities.blade.php -->
@extends('layouts.master')

@section('title', 'Hotel Facilities - BookYourHotel')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="padding: 100px 0; background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 1200 400&quot;><rect fill=&quot;%232c3e50&quot; width=&quot;1200&quot; height=&quot;400&quot;/></svg>');">
    <div class="container text-center">
        <h1>Hotel Facilities</h1>
        <p class="lead">Who are in extremely love with eco-friendly system</p>
    </div>
</section>

<!-- Facilities Grid -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row">
            @if(isset($facilities) && $facilities->count() > 0)
                <!-- Dynamic facilities from database -->
                @foreach($facilities as $facility)
                <div class="col-md-6">
                    <div class="facility-card">
                        <i class="fas fa-{{ $facility->icon ?? 'star' }}"></i>
                        <h4>{{ $facility->name }}</h4>
                        <p>{{ $facility->description }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Default static facilities -->
                <div class="col-md-6">
                    <div class="facility-card">
                        <i class="fas fa-swimming-pool"></i>
                        <h4>Kolam Renang</h4>
                        <p>Kolam renang dengan ukuran besar dan nyaman</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="facility-card">
                        <i class="fas fa-dumbbell"></i>
                        <h4>Gym</h4>
                        <p>Gym dengan nuansa asik modern</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="facility-card">
                        <i class="fas fa-hot-tub"></i>
                        <h4>Sauna</h4>
                        <p>bagus pokainya</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="facility-card">
                        <i class="fas fa-coffee"></i>
                        <h4>Caffe in Hotel</h4>
                        <p>bagus pokainya</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="facility-card">
                        <i class="fas fa-gamepad"></i>
                        <h4>Toy Museum</h4>
                        <p>bagus pokainya</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="facility-card">
                        <i class="fas fa-futbol"></i>
                        <h4>Sport Area</h4>
                        <p>bagus pokainya</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Additional Info -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="mb-4">Experience World-Class Amenities</h2>
        <p class="lead" style="max-width: 800px; margin: 0 auto;">
            Our facilities are designed to provide you with the ultimate comfort and relaxation during your stay. 
            From our state-of-the-art gym to our relaxing sauna, we have everything you need for a perfect vacation.
        </p>
    </div>
</section>
@endsection