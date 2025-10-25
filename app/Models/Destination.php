<?php
// File: app/Models/Destination.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'description',
        'image',
        'is_featured',
        'hotels_count'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'hotels_count' => 'integer'
    ];

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }
}