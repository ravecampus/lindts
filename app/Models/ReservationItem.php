<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationItem extends Model
{
    use HasFactory;
    protected $table = 'reservation_item';
    protected $fillable = [
        'image',
        'reservation_id',
        'code',
        'product_id',
        'name',
        'description',
        'quantity',
        'price',
        'food_category_id',
        'status',
    ];

    public function reserves(){
        return $this->hasMany(ReservationItem::class, 'reservation_id', 'id');
    }
   
}
