<?php
// File: app/Models/Hotel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'destination_id',
        'property_type_id',
        'name',
        'location',
        'description',
        'phone',
        'email',
        'image',
        'featured_image',
        'gallery_images',
        'status'
    ];

    protected $casts = [
        'gallery_images' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function reservations()
    {
        return $this->hasManyThrough(Reservation::class, Room::class);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function getActiveRoomsCountAttribute()
    {
        return $this->rooms()->sum('available_rooms');
    }

    public function getMinPriceAttribute()
    {
        return $this->rooms()->min('price');
    }
}