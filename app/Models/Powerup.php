<?php

namespace App\Models;

use App\Models\UserInventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Powerup extends Model
{
    use HasFactory;

    public function inventories()
    {
        return $this->belongsToMany(UserInventory::class, 'user_inventory_powerups');
    }

}
