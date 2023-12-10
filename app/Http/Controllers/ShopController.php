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

                    $user->coins -= $item->price;
                    $user->save();

                    break;

                case 'powerup':
                    $userIventory->addPowerup($item);
                    $item = Powerup::where('id', $item)->first();

                    $user->coins -= $item->price;
                    $user->save();

                    break;

                case 'upgrade':
                    $success = $userIventory->addUpgrade($item);
                    $item = Upgrade::where('id', $item)->first();

                    if (!$success) {
                        return redirect()->back()->with('error','Cannot buy another of this upgrade, you reach the buy limit. ('.$item->buy_limit.')');
                    }

                    $user->coins -= $item->price;
                    $user->save();

                    $item->price *= $item->price_multiplier_per_buy;
                    $item->save();

                    break;

                default:
                    return redirect()->back()->with('error', 'Failed to add item.');

            }

            return redirect()->back()->with('success', 'New item bought!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Could not buy the item.' . $e->getMessage() . " line: " .$e->getLine() . " file: " . $e->getFile());
        }
    }
}
