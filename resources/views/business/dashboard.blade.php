@extends('layouts.master')

@section('title', 'Business Dashboard - BookYourHotel')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Business Dashboard</h2>
                <p class="text-muted">Welcome back, {{ Auth::user()->name }}! <span class="badge bg-success">Business Account</span></p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h1 class="text-primary">{{ $totalHotels }}</h1>
                    <p class="mb-0">Total Hotels</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h1 class="text-success">{{ $totalRooms }}</h1>
                    <p class="mb-0">Total Rooms</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h1 class="text-info">{{ $totalBookings }}</h1>
                    <p class="mb-0">Total Bookings</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Quick Actions</h5>
                        <a href="{{ route('business.hotels.create') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus"></i> Add New Hotel
                        </a>
                        <a href="{{ route('business.hotels.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-hotel"></i> Manage Hotels
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hotels List -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">My Hotels</h5>
                        <a href="{{ route('business.hotels.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Add Hotel
                        </a>
                    </div>
                    <div class="card-body">
                        @if($hotels->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Hotel Name</th>
                                            <th>Location</th>
                                            <th>Rooms</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($hotels as $hotel)
                                        <tr>
                                            <td><strong>{{ $hotel->name }}</strong></td>
                                            <td>{{ $hotel->location }}</td>
                                            <td>{{ $hotel->rooms->count() }} rooms</td>
                                            <td>
                                                @if($hotel->status == 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('business.hotels.show', $hotel->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('business.hotels.edit', $hotel->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-hotel fa-4x text-muted mb-3"></i>
                                <p class="text-muted">You haven't added any hotels yet.</p>
                                <a href="{{ route('business.hotels.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Your First Hotel
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection