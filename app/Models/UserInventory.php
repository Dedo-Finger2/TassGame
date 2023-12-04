<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInventory extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function powerups()
    {
        return $this->hasMany(Powerup::class);
    }

    public function upgrades()
    {
        return $this->hasMany(Upgrade::class);
    }
}
