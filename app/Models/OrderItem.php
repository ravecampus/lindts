<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'orders_item';
    protected $fillable = [
        'image',
        'order_id',
        'code',
        'product_id',
        'name',
        'description',
        'quantity',
        'price',
        'food_category_id',
        'status',
    ];
}
