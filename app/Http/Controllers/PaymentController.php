<?php
// File: app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Reservation;

class PaymentController extends Controller
{
    public function create($reservationId)
    {
        $reservation = Reservation::with('room')->findOrFail($reservationId);
        return view('payments.create', compact('reservation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'payment_method' => 'required|in:credit_card,bank_transfer,cash'
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);

        $payment = Payment::create([
            'reservation_id' => $request->reservation_id,
            'payment_method' => $request->payment_method,
            'amount' => $reservation->total_price,
            'status' => 'completed',
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'payment_date' => now()
        ]);

        $reservation->update(['status' => 'confirmed']);

        return redirect()->route('payment.success', $payment->id)
                        ->with('success', 'Payment completed successfully!');
    }

    public function success($paymentId)
    {
        $payment = Payment::with('reservation.room')->findOrFail($paymentId);
        return view('payments.success', compact('payment'));
    }
}