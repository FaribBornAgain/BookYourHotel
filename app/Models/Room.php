<?php
// File: app/Models/Room.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'name',
        'type',
        'description',
        'price',
        'capacity',
        'image',
        'featured_image',
        'gallery_images',
        'amenities',
        'available_rooms'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'capacity' => 'integer',
        'available_rooms' => 'integer',
        'gallery_images' => 'array'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(RoomFacility::class, 'room_room_facility');
    }

    public function getAmenitiesArrayAttribute()
    {
        return $this->amenities ? explode(',', $this->amenities) : [];
    }

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