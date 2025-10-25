<?php
// File: app/Models/RoomFacility.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_room_facility');
    }
}