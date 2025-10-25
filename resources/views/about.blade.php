<!-- File: resources/views/about.blade.php -->
@extends('layouts.master')

@section('title', 'About Us - Hotel Hebat')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="mb-4">About Us</h2>
                <p class="lead">
                    Modern accommodations, topped off with an infusion of rustic charm and a residential feel. 
                    Combining comfort and functionality, simple's design concept uses warm, rich colors to offer 
                    comfort in every room.
                </p>
                <p>
                    Accents of warm autumnal fabrics and soft orange hues promote relaxation like spiced pumpkin, 
                    tangerine and amber, while modern grays create an understated cool elegance.
                </p>
                <p>
                    Our hotel is committed to providing the best service to all our guests. With strategic locations, 
                    complete facilities, and professional staff, we ensure your stay will be an unforgettable experience.
                </p>
            </div>
            <div class="col-md-6">
                <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 400'><rect fill='%23f39c12' width='600' height='400'/><circle cx='150' cy='150' r='80' fill='%23e67e22'/><circle cx='450' cy='250' r='100' fill='%23d35400'/><rect x='200' y='280' width='200' height='100' fill='%23e67e22'/><text x='300' y='340' text-anchor='middle' fill='white' font-size='24' font-family='Arial'>Hotel Hebat</text></svg>" 
                     class="img-fluid rounded shadow" alt="About Hotel Hebat">
            </div>
        </div>

        <!-- Stats Section -->
        <div class="row mt-5 text-center">
            <div class="col-md-3">
                <div class="card p-4">
                    <h2 class="text-primary"><i class="fas fa-bed"></i></h2>
                    <h3>50+</h3>
                    <p>Comfortable Rooms</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4">
                    <h2 class="text-primary"><i class="fas fa-users"></i></h2>
                    <h3>1000+</h3>
                    <p>Happy Guests</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4">
                    <h2 class="text-primary"><i class="fas fa-star"></i></h2>
                    <h3>4.8/5</h3>
                    <p>Average Rating</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4">
                    <h2 class="text-primary"><i class="fas fa-award"></i></h2>
                    <h3>10+</h3>
                    <p>Years Experience</p>
                </div>
            </div>
        </div>

        <!-- Mission Section -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card p-5" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
                    <h3 class="text-center mb-4">Our Mission</h3>
                    <p class="text-center lead">
                        To provide exceptional hospitality services that exceed our guests' expectations, 
                        ensuring comfort, safety, and memorable experiences in a warm and welcoming environment.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection