<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Powerup;
use App\Models\Upgrade;
use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function itemShop()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $canBuyItems = Item::where('price', '<=', $user->coins)->get();

        return view('item.shop', [
            'canBuyItems' => $canBuyItems,
        ]);
    }


    public function powerupShop()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $canBuyPowerups = Powerup::where('price', '<=', $user->coins)->get();

        return view('powerup.shop', [
            'canBuyPowerups' => $canBuyPowerups,
        ]);
    }


    public function upgradeShop()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $canBuyUpgrades = Upgrade::where('price', '<=', $user->coins)
            ->where('level', '<=', $user->level)
            ->get();

        return view('upgrade.shop', [
            'canBuyUpgrades' => $canBuyUpgrades,
        ]);
    }


    public function buy(mixed $item, Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $userIventory = new UserInventoryController;
        $itemType = $request->item_type;

        try {
            switch ($itemType) {
                case 'item':
                    $userIventory->addItem($item);
                    $item = Item::where('id', $item)->first();
                    break;

                case 'powerup':
                    $userIventory->addPowerup($item);
                    $item = Powerup::where('id', $item)->first();
                    break;

                case 'upgrade':
                    $userIventory->addUpgrade($item);
                    $item = Upgrade::where('id', $item)->first();
                    break;

                default:
                    return redirect()->back()->with('error', 'Failed to add item.');

            }

            $user->coins -= $item->price;
            $user->save();

            return redirect()->back()->with('success', 'New item bought!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Could not buy the item.' . $e->getMessage());
        }
    }
}
