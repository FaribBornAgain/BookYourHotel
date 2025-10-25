<?php
// File: app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Room;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Reservation::with('room', 'payment')
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        return view('transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Reservation::with('room', 'payment')->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function myTransactions(Request $request)
    {
        // Search by email
        if ($request->has('email')) {
            $transactions = Reservation::with('room', 'payment')
                                       ->where('guest_email', $request->email)
                                       ->orderBy('created_at', 'desc')
                                       ->get();
            
            return view('transactions.my-transactions', compact('transactions'));
        }

        return view('transactions.search');
    }

    public function searchByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $transactions = Reservation::with('room', 'payment')
                                   ->where('guest_email', $request->email)
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return view('transactions.my-transactions', compact('transactions'));
    }

    public function searchByReservationNumber(Request $request)
    {
        $request->validate([
            'reservation_number' => 'required|string'
        ]);

        $transaction = Reservation::with('room', 'payment')
                                  ->where('reservation_number', $request->reservation_number)
                                  ->first();

        if (!$transaction) {
            return redirect()->back()->with('error', 'Reservation not found!');
        }

        return view('transactions.show', compact('transaction'));
    }

    public function receipt($id)
    {
        $transaction = Reservation::with('room', 'payment')->findOrFail($id);
        return view('transactions.receipt', compact('transaction'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $transaction = Reservation::findOrFail($id);
        $transaction->update(['status' => $request->status]);

        return redirect()->back()
                        ->with('success', 'Transaction status updated successfully!');
    }

    public function cancel($id)
    {
        $transaction = Reservation::findOrFail($id);
        
        if ($transaction->status === 'completed') {
            return redirect()->back()
                           ->with('error', 'Cannot cancel a completed reservation!');
        }

        $transaction->update(['status' => 'cancelled']);

        // Update payment status if exists
        if ($transaction->payment) {
            $transaction->payment->update(['status' => 'failed']);
        }

        return redirect()->back()
                        ->with('success', 'Reservation cancelled successfully!');
    }

    public function summary()
    {
        $totalReservations = Reservation::count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $confirmedReservations = Reservation::where('status', 'confirmed')->count();
        $cancelledReservations = Reservation::where('status', 'cancelled')->count();
        $completedReservations = Reservation::where('status', 'completed')->count();
        
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->sum('amount');

        return view('transactions.summary', compact(
            'totalReservations',
            'pendingReservations',
            'confirmedReservations',
            'cancelledReservations',
            'completedReservations',
            'totalRevenue',
            'pendingPayments'
        ));
    }

    public function filterByStatus($status)
    {
        $transactions = Reservation::with('room', 'payment')
                                   ->where('status', $status)
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return view('transactions.index', compact('transactions', 'status'));
    }

    public function filterByDateRange(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $transactions = Reservation::with('room', 'payment')
                                   ->whereBetween('check_in_date', [$request->start_date, $request->end_date])
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return view('transactions.index', compact('transactions'));
    }
}