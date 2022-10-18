<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'order_number',
        'user_id',
        'full_name',
        'mobile_number',
        'delivery_address',
        'amount',
        'total',
        'grand_total',
        'delivery_fee',
        'payment_mode',
        'status',
        'received_date',
    ];

}
