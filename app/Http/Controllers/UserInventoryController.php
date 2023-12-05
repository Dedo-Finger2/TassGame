<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\UserInventory;
use App\Models\UserInventoryItem;

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
            'item_id' => $item->id ? $item->id : $item,
        ];

        UserInventoryItem::create($data);
    }
}
