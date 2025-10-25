<?php
// File: app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Reservation;
use App\Notifications\BookingConfirmation;
use Illuminate\Support\Facades\Notification;

class PaymentController extends Controller
{
    public function create($reservationId)
    {
        $reservation = Reservation::with('room.hotel')->findOrFail($reservationId);
        return view('payments.create', compact('reservation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'payment_method' => 'required|in:credit_card,bank_transfer,cash,bkash'
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);

        // If bKash is selected, redirect to bKash payment form
        if ($request->payment_method === 'bkash') {
            return redirect()->route('payment.bkash.form', $reservation->id);
        }

        // Process other payment methods
        $payment = Payment::create([
            'reservation_id' => $request->reservation_id,
            'payment_method' => $request->payment_method,
            'amount' => $reservation->total_price,
            'status' => $request->payment_method === 'cash' ? 'pending' : 'completed',
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'payment_date' => now(),
            'confirmed_at' => now()
        ]);

        $reservation->update(['status' => 'confirmed']);

        // Send email confirmation
        try {
            Notification::route('mail', $reservation->guest_email)
                ->notify(new BookingConfirmation($reservation));
        } catch (\Exception $e) {
            // Log error but don't fail the booking
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

        return redirect()->route('payment.success', $payment->id)
                        ->with('success', 'Payment completed successfully! Confirmation email sent.');
    }

    public function bkashForm($reservationId)
    {
        $reservation = Reservation::with('room.hotel')->findOrFail($reservationId);
        return view('payments.bkash', compact('reservation'));
    }

    public function bkashProcess(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'bkash_number' => 'required|string|min:11|max:11',
            'bkash_trx_id' => 'required|string'
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);

        $payment = Payment::create([
            'reservation_id' => $request->reservation_id,
            'payment_method' => 'bkash',
            'amount' => $reservation->total_price,
            'status' => 'pending', // Admin needs to verify
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'bkash_trx_id' => $request->bkash_trx_id,
            'payment_phone' => $request->bkash_number,
            'payment_details' => json_encode([
                'bkash_number' => $request->bkash_number,
                'bkash_trx_id' => $request->bkash_trx_id,
                'submitted_at' => now()
            ]),
            'payment_date' => now()
        ]);

        $reservation->update(['status' => 'pending']);

        return redirect()->route('payment.success', $payment->id)
                        ->with('success', 'bKash payment submitted! Waiting for admin verification.');
    }

    public function success($paymentId)
    {
        $payment = Payment::with('reservation.room.hotel')->findOrFail($paymentId);
        return view('payments.success', compact('payment'));
    }

    // Admin verify bKash payment
    public function verifyBkash(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        
        $payment->update([
            'status' => 'completed',
            'confirmed_at' => now()
        ]);

        $payment->reservation->update(['status' => 'confirmed']);

        // Send confirmation email
        try {
            Notification::route('mail', $payment->reservation->guest_email)
                ->notify(new BookingConfirmation($payment->reservation));
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Payment verified and confirmation email sent!');
    }
}