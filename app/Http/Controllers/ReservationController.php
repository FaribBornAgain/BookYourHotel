<?php
// File: app/Http/Controllers/ReservationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create($roomId)
    {
        $room = Room::findOrFail($roomId);
        return view('reservations.create', compact('room'));
    }

    public function store(Request $request)
{
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'guest_name' => 'required|string|max:255',
        'guest_email' => 'required|email',
        'guest_phone' => 'required|string',
        'check_in_date' => 'required|date|after_or_equal:today',
        'check_out_date' => 'required|date|after:check_in_date',
        'number_of_guests' => 'required|integer|min:1',
        'number_of_rooms' => 'required|integer|min:1'
    ]);

    $room = Room::findOrFail($request->room_id);
    
    $checkIn = Carbon::parse($request->check_in_date);
    $checkOut = Carbon::parse($request->check_out_date);
    $nights = $checkIn->diffInDays($checkOut);
    
    $totalPrice = $room->price * $nights * $request->number_of_rooms;

    $reservation = Reservation::create([
        'user_id' => auth()->id(), // NEW: Link to logged-in user
        'room_id' => $request->room_id,
        'guest_name' => $request->guest_name,
        'guest_email' => $request->guest_email,
        'guest_phone' => $request->guest_phone,
        'check_in_date' => $request->check_in_date,
        'check_out_date' => $request->check_out_date,
        'number_of_guests' => $request->number_of_guests,
        'number_of_rooms' => $request->number_of_rooms,
        'total_price' => $totalPrice,
        'special_requests' => $request->special_requests,
        'status' => 'pending'
    ]);

    return redirect()->route('payment.create', $reservation->id)
                    ->with('success', 'Reservation created successfully!');
}
    public function show($id)
    {
        $reservation = Reservation::with('room', 'payment')->findOrFail($id);
        return view('reservations.show', compact('reservation'));
    }

    public function myReservations()
{
    if (auth()->check()) {
        // If user is logged in, show their reservations
        $reservations = Reservation::with('room', 'payment')
                                   ->where('user_id', auth()->id())
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        return view('reservations.my-reservations', compact('reservations'));
    }
    
    // If not logged in, show empty state
    return view('reservations.my-reservations');
}

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Reservation cancelled successfully!');
    }
}