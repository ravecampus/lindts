<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationJson extends Model
{
    use HasFactory;

    protected $table = 'reservation_json';
    protected $fillable = ['user_id', 'json_data'];

}
