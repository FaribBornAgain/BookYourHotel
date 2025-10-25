<?php
// File: app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'payment_method',
        'amount',
        'status',
        'transaction_id',
        'bkash_trx_id',
        'payment_phone',
        'payment_details',
        'payment_date',
        'confirmed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'confirmed_at' => 'datetime',
        'payment_details' => 'array'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isBkash()
    {
        return $this->payment_method === 'bkash';
    }
}