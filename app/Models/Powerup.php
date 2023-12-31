<?php

namespace App\Models;

use App\Models\UserInventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Powerup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'uses',
        'multiplier',
        'bought',
        'bought_date',
    ];

    public function inventories()
    {
        return $this->belongsToMany(UserInventory::class, 'user_inventory_powerups');
    }

}
