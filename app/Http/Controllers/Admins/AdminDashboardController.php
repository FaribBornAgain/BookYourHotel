<?php
// File: app/Http/Controllers/Admin/AdminDashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Payment;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // Statistics
        $totalUsers = User::count();
        $totalHotels = Hotel::count();
        $totalReservations = Reservation::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        
        // Recent bookings
        $recentBookings = Reservation::with(['room.hotel', 'payment', 'user'])
                                     ->latest()
                                     ->take(10)
                                     ->get();
        
        // Pending payments (bKash verifications)
        $pendingPayments = Payment::with('reservation.room.hotel')
                                  ->where('payment_method', 'bkash')
                                  ->where('status', 'pending')
                                  ->latest()
                                  ->get();
        
        // Monthly revenue chart data
        $monthlyRevenue = Payment::where('status', 'completed')
                                ->whereYear('created_at', date('Y'))
                                ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
                                ->groupBy('month')
                                ->pluck('total', 'month');
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalHotels',
            'totalReservations',
            'totalRevenue',
            'recentBookings',
            'pendingPayments',
            'monthlyRevenue'
        ));
    }

    public function bookings()
    {
        $bookings = Reservation::with(['room.hotel', 'payment', 'user'])
                              ->latest()
                              ->paginate(20);
        
        return view('admin.bookings', compact('bookings'));
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function hotels()
    {
        $hotels = Hotel::with('user')->latest()->paginate(20);
        return view('admin.hotels', compact('hotels'));
    }
}