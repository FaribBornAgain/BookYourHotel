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
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public function isGuest()
    {
        return $this->user_type === 'guest';
    }

    public function isBusiness()
    {
        return $this->user_type === 'business';
    }

    public function isAdmin()
    {
        return $this->is_admin === true;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }
}