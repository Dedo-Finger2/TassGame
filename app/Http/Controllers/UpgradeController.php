<?php

namespace App\Http\Controllers;

use App\Models\Powerup;
use App\Models\Upgrade;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserInventory;
use App\Models\UserInventoryUpgrade;
use Illuminate\Support\Facades\Storage;

class UpgradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $upgrades = Upgrade::all();

        return view("upgrade.index", [
            "upgrades" => $upgrades,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('upgrade.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => ['nullable', 'image', 'max:2048', 'mimes:png,jpg,jpeg'],
            'name' => ['required', 'string', 'unique:upgrades'],
            'price' => ['required', 'numeric', 'min:1'],
            'description' => ['string', 'min:3'],
            'type' => ['string'],
            'buy_limit' => ['required', 'min:1'],
            'level' => ['required', 'min:1'],
            'multiplier' => ['numeric', 'min:1.1'],
            'price_multiplier_per_buy' => ['required', 'min:1.1'],
            'action_value' => ['required', 'min:1'],
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName()) . strtotime('now') . '.' . $extension;

            $requestImage->move(public_path('img/upgrades'), $imageName);

            $data['image'] = $imageName;
        }

        Upgrade::create($data);

        return redirect()->route('upgrades.index')->with('success', 'New upgrade added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Upgrade $upgrade)
    {
        $userInventoryId = UserInventory::where('user_id', auth()->user()->id)->first();

        if (isset($userInventoryId)) {
            $userInventoryId = $userInventoryId->pluck('id');
            $userUpgradeBoughtAmount = UserInventoryUpgrade::where('user_inventory_id', $userInventoryId)
                ->where('upgrade_id', $upgrade->id)
                ->get();
        } else
            $userUpgradeBoughtAmount = [];


        return view('upgrade.show', [
            'upgrade' => $upgrade,
            'userUpgradeBoughtAmount' => count($userUpgradeBoughtAmount),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Upgrade $upgrade)
    {
        return view('upgrade.edit', [
            'upgrade' => $upgrade,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Upgrade $upgrade)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:upgrades,name,' . $upgrade->id],
            'price' => ['required', 'numeric', 'min:1'],
            'description' => ['string', 'min:3'],
            'type' => ['string'],
            'buy_limit' => ['required', 'min:1'],
            'level' => ['required', 'min:1'],
            'multiplier' => ['numeric', 'min:1.1'],
            'price_multiplier_per_buy' => ['required', 'min:1.1'],
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if (file_exists(public_path("img/upgrades/$upgrade->image"))) {
                unlink(public_path("img/upgrades/$upgrade->image"));
            }

            $requestImage = $request->image;
            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName()) . strtotime('now') . '.' . $extension;

            $requestImage->move(public_path('img/upgrades'), $imageName);

            $data['image'] = $imageName;
        }

        try {
            $upgrade->update($data);
            return redirect()->route('upgrades.index')->with('success', 'Upgrade updated!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Upgrade $upgrade)
    {
        try {
            $upgrade->delete();
            return redirect()->route('upgrades.index')->with('success', 'Upgrade deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cant delete this upgrade because you have it in your inventory.');
        }
    }


    public static function applyUpgrade(Upgrade|string $upgrade)
    {
        switch ($upgrade->name) {
            case 'Better Powerup Bag':
                self::betterPowerupBag($upgrade);
                break;
            case 'Better Coin Bag':
                self::betterCoinBag($upgrade);
                break;

            default:
                # code...
                break;
        }
    }


    private static function upgradeUpdateValues(Upgrade $upgrade)
    {
        $upgrade->action_value *= $upgrade->multiplier;
        $upgrade->multiplier += 0.1;

        $upgrade->save();
    }


    // * Upgrades
    private static function betterPowerupBag(Upgrade $upgrade)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user->powerup_limit += $upgrade->action_value;
        $user->save();

        self::upgradeUpdateValues($upgrade);
    }

    private static function betterCoinBag(Upgrade $upgrade)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user->coin_limit += $upgrade->action_value;
        $user->save();

        self::upgradeUpdateValues($upgrade);
    }

}
