<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservation';
    
    protected $fillable = [
        'reservation_number', 
        'user_id', 
        'full_name', 
        'mobile_number',
        'total',
        'number_of_person',
        'reservation_date',
        'reservation_time',
        'status',
    ];
}
