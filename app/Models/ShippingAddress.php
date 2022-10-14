<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;
    protected $table = 'shipping_address';
    protected $fillable = [
        'user_id', 
        'full_name', 
        'Address', 
        'mobile_number',
        'default'
    ];
}
