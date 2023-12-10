<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Powerup;
use App\Models\Upgrade;
use Exception;
use Illuminate\Http\Request;
use App\Models\UserInventory;
use App\Models\UserInventoryItem;
use Illuminate\Support\Facades\DB;
use App\Models\UserInventoryPowerup;
use App\Models\UserInventoryUpgrade;

class UserInventoryController extends Controller
{
    private function createNewInventory()
    {
        $userInventory = UserInventory::where('user_id', auth()->user()->id)->get();

        if (!$userInventory || count($userInventory) <= 0) {
            $data = [
                'user_id' => auth()->user()->id,
            ];

            UserInventory::create($data);
        }

        return $userInventory->pluck('id');
    }

    public function addItem(Item|int $item)
    {
        $userInventoryId = $this->createNewInventory()[0];

        $data = [
            'user_inventory_id' => $userInventoryId,
            'item_id' => $item,
        ];

        UserInventoryItem::create($data);
    }

    public function addPowerup(Powerup|int $powerup)
    {
        $userInventoryId = $this->createNewInventory()[0];
        // dd($userInventoryId);

        $data = [
            'user_inventory_id' => $userInventoryId,
            'powerup_id' => $powerup,
        ];

        $powerup = Powerup::where('id', $powerup)->first();
        $powerup->bought = true;
        $powerup->bought_date = now();
        $powerup->save();

        UserInventoryPowerup::create($data);
    }


    public function addUpgrade(Upgrade|int $upgrade)
    {
        $userInventoryId = $this->createNewInventory()[0];
        // dd($userInventoryId);

        $data = [
            'user_inventory_id' => $userInventoryId,
            'upgrade_id' => $upgrade,
        ];

        $upgrade = Upgrade::where('id', $upgrade)->first();

        $upgradesUserGot = UserInventoryUpgrade::where('upgrade_id', $upgrade->id)->get();

        if (count($upgradesUserGot) >= $upgrade->buy_limit) {
            $upgrade->can_buy = false;
            $upgrade->save();
            return false;
        }

        UserInventoryUpgrade::create($data);

        UpgradeController::applyUpgrade($upgrade);

        return true;
    }


    public static function removePowerupFromInventory(Powerup|int $powerup, int $userInventoryId)
    {
        DB::table('user_inventory_powerups')->where('powerup_id', $powerup->id)->where('user_inventory_id', $userInventoryId)->limit(1)->delete();
    }
}
