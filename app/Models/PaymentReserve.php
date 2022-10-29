<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReserve extends Model
{
    use HasFactory;

    protected $table = "payment_reserve";
    protected $fillable = [
        'reservation_id', 
        'user_id', 
        'payment_id',
        'payer_id',
        'amount',
        'payer_email',
        'currency',
        'payment_status',
    ];
}
