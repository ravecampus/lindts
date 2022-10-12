<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTray extends Model
{
    use HasFactory;
    protected $table = 'user_tray';
    protected $fillable = ['user_id', 'json_data'];
}
