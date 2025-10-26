<!-- File: resources/views/payments/success.blade.php -->
@extends('layouts.master')

@section('title', 'Payment Successful - BookYourHotel')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                        </div>
                        <h2 class="text-success mb-3">Payment Successful!</h2>
                        <p class="lead">Thank you for your booking. Your reservation has been confirmed.</p>

                        <div class="alert alert-info my-4">
                            <h5>Transaction Details</h5>
                            <hr>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="text-start"><strong>Transaction ID:</strong></td>
                                    <td class="text-end">{{ $payment->transaction_id }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start"><strong>Reservation Number:</strong></td>
                                    <td class="text-end">{{ $payment->reservation->reservation_number }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start"><strong>Payment Method:</strong></td>
                                    <td class="text-end">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start"><strong>Amount Paid:</strong></td>
                                    <td class="text-end"><strong>Tk. {{ number_format($payment->amount, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-start"><strong>Payment Date:</strong></td>
                                    <td class="text-end">{{ $payment->payment_date->format('d M Y, H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Booking Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-start">
                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Guest Name</small>
                                        <p class="mb-0"><strong>{{ $payment->reservation->guest_name }}</strong></p>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Room Type</small>
                                        <p class="mb-0"><strong>{{ $payment->reservation->room->name }}</strong></p>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Check-in</small>
                                        <p class="mb-0"><strong>{{ $payment->reservation->check_in_date->format('d M Y') }}</strong></p>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Check-out</small>
                                        <p class="mb-0"><strong>{{ $payment->reservation->check_out_date->format('d M Y') }}</strong></p>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Number of Guests</small>
                                        <p class="mb-0"><strong>{{ $payment->reservation->number_of_guests }}</strong></p>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <small class="text-muted">Number of Rooms</small>
                                        <p class="mb-0"><strong>{{ $payment->reservation->number_of_rooms }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i> A confirmation email has been sent to <strong>{{ $payment->reservation->guest_email }}</strong>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-home"></i> Back To Home
                            </a>
                            <a href="{{ route('reservations.my') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-list"></i> View My Reservations
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection