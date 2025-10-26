<!-- File: resources/views/payments/create.blade.php -->
@extends('layouts.master')

@section('title', 'Payment - BookYourHotel')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Complete Your Payment</h4>
                    </div>
                    <div class="card-body">
                        <!-- Reservation Summary -->
                        <h5 class="mb-3">Reservation Summary</h5>
                        <table class="table">
                            <tr>
                                <td><strong>Reservation Number:</strong></td>
                                <td>{{ $reservation->reservation_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Room Type:</strong></td>
                                <td>{{ $reservation->room->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Guest Name:</strong></td>
                                <td>{{ $reservation->guest_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Check-in:</strong></td>
                                <td>{{ $reservation->check_in_date->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Check-out:</strong></td>
                                <td>{{ $reservation->check_out_date->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Number of Nights:</strong></td>
                                <td>{{ $reservation->number_of_nights }}</td>
                            </tr>
                            <tr>
                                <td><strong>Number of Rooms:</strong></td>
                                <td>{{ $reservation->number_of_rooms }}</td>
                            </tr>
                            <tr class="table-active">
                                <td><strong>Total Amount:</strong></td>
                                <td><strong class="text-primary" style="font-size: 1.3rem;">Tk. {{ number_format($reservation->total_price, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>

                        <hr class="my-4">

                        <!-- Payment Form -->
                        <h5 class="mb-3">Select Payment Method</h5>
                        <form action="{{ route('payment.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

                            <div class="mb-4">
    <!-- bKash Payment -->
    <div class="form-check mb-3 p-3 border rounded" style="border-left: 4px solid #E2136E !important;">
        <input class="form-check-input" type="radio" name="payment_method" id="bkash" value="bkash" required>
        <label class="form-check-label" for="bkash">
            <img src="https://seeklogo.com/images/B/bkash-logo-835789094F-seeklogo.com.png" height="24" alt="bKash">
            <strong>bKash Payment</strong>
            <p class="text-muted small mb-0">Pay with bKash - Fast & Secure</p>
        </label>
    </div>

    <div class="form-check mb-3 p-3 border rounded">
        <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" required>
        <label class="form-check-label" for="credit_card">
            <i class="fas fa-credit-card"></i> <strong>Credit/Debit Card</strong>
            <p class="text-muted small mb-0">Pay securely with your card</p>
        </label>
    </div>

    <div class="form-check mb-3 p-3 border rounded">
        <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" required>
        <label class="form-check-label" for="bank_transfer">
            <i class="fas fa-university"></i> <strong>Bank Transfer</strong>
            <p class="text-muted small mb-0">Transfer to our bank account</p>
        </label>
    </div>

    <div class="form-check mb-3 p-3 border rounded">
        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" required>
        <label class="form-check-label" for="cash">
            <i class="fas fa-money-bill-wave"></i> <strong>Cash on Arrival</strong>
            <p class="text-muted small mb-0">Pay when you check-in</p>
        </label>
    </div>
</div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-lock"></i> COMPLETE PAYMENT
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection