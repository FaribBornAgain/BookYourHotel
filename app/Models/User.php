<?php
// File: app/Models/User.php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isGuest()
    {
        return $this->user_type === 'guest';
    }

    public function isBusiness()
    {
        return $this->user_type === 'business';
    }

    // Relationship: User has many Hotels (for business accounts)
public function hotels()
{
    return $this->hasMany(Hotel::class);
}

// Relationship: User has many Reservations (for guest accounts)
public function reservations()
{
    return $this->hasMany(Reservation::class);
}
}