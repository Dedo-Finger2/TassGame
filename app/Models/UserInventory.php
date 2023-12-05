<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'powerup_id',
        'upgrade_id',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'user_inventory_items');
    }

    public function powerups()
    {
        return $this->belongsToMany(Powerup::class, 'user_inventory_powerups');
    }

    public function upgrades()
    {
        return $this->belongsToMany(Upgrade::class, 'user_inventory_upgrades');
    }


}
