<?php
// File: app/Models/Room.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'price',
        'capacity',
        'image',
        'amenities',
        'available_rooms'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'capacity' => 'integer',
        'available_rooms' => 'integer'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // NEW: Relationship with RoomFacility
    public function facilities()
    {
        return $this->belongsToMany(RoomFacility::class, 'room_room_facility');
    }

    public function getAmenitiesArrayAttribute()
    {
        return $this->amenities ? explode(',', $this->amenities) : [];
    }

    // NEW: Check if room type
    public function isStandard()
    {
        return $this->type === 'standard';
    }

    public function isSuperior()
    {
        return $this->type === 'superior';
    }

    public function isDeluxe()
    {
        return $this->type === 'deluxe';
    }
}