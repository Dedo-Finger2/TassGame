<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $allItems = Item::all();
        $canBuyItems = Item::where('price', '<=', $user->coins)->get();

        return view('item.shop', [
            'items' => $allItems,
            'canBuyItems' => $canBuyItems,
        ]);
    }


    public function buy(Item $item)
    {
        $user = User::where('id', auth()->user()->id)->first();

        try {
            $userIventory = new UserInventoryController;
            $userIventory->addItem($item);

            $user->coins -= $item->price;
            $user->save();

            return redirect()->back()->with('success', 'New item bought!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Could not buy the item.'.$e->getMessage());
        }
    }
}
