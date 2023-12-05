<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInventoryItem extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'item_id',
        'user_inventory_id',
    ];

    use HasFactory;
}
