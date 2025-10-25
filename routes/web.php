<?php
// File: routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HotelFacilityController;
use App\Http\Controllers\RoomFacilityController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\TransactionController;

// Authentication Routes
Auth::routes();

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/facilities', [HotelFacilityController::class, 'index'])->name('facilities');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Room routes
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('rooms.show');
Route::post('/rooms/check-availability', [RoomController::class, 'checkAvailability'])->name('rooms.checkAvailability');

// Room Type routes
Route::get('/room-types', [RoomTypeController::class, 'index'])->name('room-types.index');
Route::get('/room-types/{type}', [RoomTypeController::class, 'show'])->name('room-types.show');
Route::get('/room-types/standard', [RoomTypeController::class, 'standard'])->name('room-types.standard');
Route::get('/room-types/superior', [RoomTypeController::class, 'superior'])->name('room-types.superior');
Route::get('/room-types/deluxe', [RoomTypeController::class, 'deluxe'])->name('room-types.deluxe');
Route::post('/room-types/filter', [RoomTypeController::class, 'filterByType'])->name('room-types.filter');

// Reservation routes
Route::get('/reservations/create/{roomId}', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
Route::get('/my-reservations', [ReservationController::class, 'myReservations'])->name('reservations.my');
Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

// Payment routes
Route::get('/payment/{reservationId}', [PaymentController::class, 'create'])->name('payment.create');
Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/payment/success/{paymentId}', [PaymentController::class, 'success'])->name('payment.success');

// Transaction routes
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('/my-transactions', [TransactionController::class, 'myTransactions'])->name('transactions.my');
Route::post('/transactions/search-email', [TransactionController::class, 'searchByEmail'])->name('transactions.searchByEmail');
Route::post('/transactions/search-number', [TransactionController::class, 'searchByReservationNumber'])->name('transactions.searchByNumber');
Route::get('/transactions/{id}/receipt', [TransactionController::class, 'receipt'])->name('transactions.receipt');

// Admin routes (protected)
Route::middleware(['auth'])->group(function () {
    // Hotel Facilities Management
    Route::resource('admin/hotel-facilities', HotelFacilityController::class);
    
    // Room Facilities Management
    Route::resource('admin/room-facilities', RoomFacilityController::class);
    Route::post('/admin/rooms/{roomId}/attach-facility', [RoomFacilityController::class, 'attachToRoom'])->name('room-facilities.attach');
    Route::delete('/admin/rooms/{roomId}/detach-facility/{facilityId}', [RoomFacilityController::class, 'detachFromRoom'])->name('room-facilities.detach');
    
    // Transaction Management
    Route::post('/admin/transactions/{id}/update-status', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
    Route::get('/admin/transactions/summary', [TransactionController::class, 'summary'])->name('transactions.summary');
    Route::get('/admin/transactions/status/{status}', [TransactionController::class, 'filterByStatus'])->name('transactions.filterByStatus');
    Route::post('/admin/transactions/filter-dates', [TransactionController::class, 'filterByDateRange'])->name('transactions.filterByDateRange');
});
// Business Dashboard Routes (Protected - Business users only)
Route::middleware(['auth'])->prefix('business')->name('business.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Business\DashboardController::class, 'index'])->name('dashboard');
    
    // Hotels Management
    Route::resource('hotels', App\Http\Controllers\Business\HotelController::class);
    
    // Rooms Management
    Route::get('/hotels/{hotel}/rooms/create', [App\Http\Controllers\Business\BusinessRoomController::class, 'create'])->name('rooms.create');
    Route::post('/hotels/{hotel}/rooms', [App\Http\Controllers\Business\BusinessRoomController::class, 'store'])->name('rooms.store');
    Route::get('/hotels/{hotel}/rooms/{room}/edit', [App\Http\Controllers\Business\BusinessRoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/hotels/{hotel}/rooms/{room}', [App\Http\Controllers\Business\BusinessRoomController::class, 'update'])->name('rooms.update');
    Route::delete('/hotels/{hotel}/rooms/{room}', [App\Http\Controllers\Business\BusinessRoomController::class, 'destroy'])->name('rooms.destroy');
});

// Public Hotel/Destination Routes
Route::get('/hotels/{id}', [App\Http\Controllers\HotelPublicController::class, 'show'])->name('hotels.show');
Route::get('/destinations/{id}', [App\Http\Controllers\DestinationController::class, 'show'])->name('destination.show');
Route::get('/property-types/{id}', [App\Http\Controllers\PropertyTypeController::class, 'show'])->name('property-type.show');