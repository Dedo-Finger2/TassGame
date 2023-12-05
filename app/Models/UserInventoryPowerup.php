<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInventoryPowerup extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'powerup_id',
        'user_inventory_id',
    ];

    use HasFactory;
}
