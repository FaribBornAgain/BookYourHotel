<?php
// File: app/Models/Reservation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_number',
        'user_id',
        'room_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in_date',
        'check_out_date',
        'number_of_guests',
        'number_of_rooms',
        'total_price',
        'status',
        'special_requests'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_price' => 'decimal:2',
        'number_of_guests' => 'integer',
        'number_of_rooms' => 'integer'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // NEW: Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNumberOfNightsAttribute()
    {
        return Carbon::parse($this->check_in_date)->diffInDays($this->check_out_date);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reservation) {
            $reservation->reservation_number = 'RES-' . strtoupper(uniqid());
        });
    }
}