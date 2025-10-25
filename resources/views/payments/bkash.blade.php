@extends('layouts.master')

@section('title', 'bKash Payment - Hotel Hebat')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background: #E2136E; color: white;">
                        <h4 class="mb-0">
                            <img src="https://seeklogo.com/images/B/bkash-logo-835789094F-seeklogo.com.png" 
                                 height="30" alt="bKash"> bKash Payment
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Payment Instructions -->
                        <div class="alert alert-info">
                            <h5><i class="fas fa-info-circle"></i> Payment Instructions:</h5>
                            <ol class="mb-0">
                                <li>Open your bKash app</li>
                                <li>Go to "Send Money" or "Payment"</li>
                                <li>Enter our bKash Merchant Number: <strong>01812-345678</strong></li>
                                <li>Send exactly: <strong>Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</strong></li>
                                <li>Copy the Transaction ID (TrxID)</li>
                                <li>Enter details below</li>
                            </ol>
                        </div>

                        <!-- Reservation Summary -->
                        <div class="card mb-4" style="background: #f8f9fa;">
                            <div class="card-body">
                                <h5>Payment Summary</h5>
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td><strong>Reservation Number:</strong></td>
                                        <td>{{ $reservation->reservation_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Hotel:</strong></td>
                                        <td>{{ $reservation->room->hotel->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Room:</strong></td>
                                        <td>{{ $reservation->room->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Guest Name:</strong></td>
                                        <td>{{ $reservation->guest_name }}</td>
                                    </tr>
                                    <tr class="table-active">
                                        <td><strong>Total Amount:</strong></td>
                                        <td><h4 class="mb-0 text-danger">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</h4></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Payment Form -->
                        <form action="{{ route('payment.bkash.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

                            <div class="mb-3">
                                <label class="form-label">Your bKash Number *</label>
                                <input type="text" name="bkash_number" class="form-control" 
                                       placeholder="01XXXXXXXXX" required maxlength="11" minlength="11"
                                       pattern="[0-9]{11}">
                                <small class="text-muted">Enter 11-digit bKash number (e.g., 01812345678)</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">bKash Transaction ID (TrxID) *</label>
                                <input type="text" name="bkash_trx_id" class="form-control" 
                                       placeholder="8N7A6M5P4L3" required>
                                <small class="text-muted">You'll receive this after completing payment in bKash app</small>
                            </div>

                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> <strong>Important:</strong> 
                                Your booking will be pending until we verify your bKash payment. 
                                Verification usually takes 5-10 minutes.
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-lg" style="background: #E2136E; color: white;">
                                    <i class="fas fa-check-circle"></i> Submit Payment Details
                                </button>
                                <a href="{{ route('payment.create', $reservation->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Choose Different Payment Method
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- bKash Support -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6>Need Help?</h6>
                        <p class="mb-0">
                            <i class="fas fa-phone"></i> Call bKash Helpline: 16247<br>
                            <i class="fas fa-envelope"></i> Email us: support@hotelhebat.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection