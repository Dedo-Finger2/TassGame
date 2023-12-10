<?php

namespace App\Http\Controllers;

use App\Models\RemainingPowerup;
use App\Models\User;
use App\Models\UserInventory;
use App\Models\UserInventoryItem;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        return view("user.profile", [
            "user" => $user,
        ]);
    }


    public function dashboard()
    {
        return view("user.dashboard");
    }


    public function inventory()
    {
        $userInventory = UserInventory::where('user_id', auth()->user()->id)->first();

        if ($userInventory) {
            $activePowerups = RemainingPowerup::where('remaining_powerups.user_inventory_id', $userInventory->id)
                ->join("powerups", "remaining_powerups.powerup_id", "=", "powerups.id")
                ->get();
        } else $activePowerups = null;

        return view('user.inventory', [
            'userInventory' => $userInventory,
            'activePowerups' => $activePowerups,
        ]);
    }


    public static function earnCoins(int $amount)
    {
        $user = User::find(auth()->user()->id);

        if ($amount <= 0)
            return redirect()->back()->with("error", "Invalid amount of coins.");

        $user->coins += $amount;
        $user->save();
    }


    public static function earnExp(int $amount)
    {
        $user = User::find(auth()->user()->id);

        if ($amount <= 0)
            return redirect()->back()->with("error", "Invalid amount of exp.");

        $user->exp += $amount;

        while ($user->exp >= $user->exp_next_level) {
            $user->exp -= $user->exp_next_level;
            $user->level += 1;
            $user->exp_next_level += 50;
        }

        $user->save();
    }



    public static function loseCoins(int $amount)
    {
        $user = User::find(auth()->user()->id);

        if ($amount <= 0)
            return redirect()->back()->with("error", "Invalid amount of coins.");

        $user->coins -= $amount;

        if ($user->coins < 0)
            $user->coins = 0;

        $user->save();
    }

    // TODO: Concertar, está num loop inifinito
    public static function loseExp(int $amount)
    {
        $user = User::find(auth()->user()->id);

        if ($amount <= 0) {
            return redirect()->back()->with("error", "Invalid amount of exp.");
        }

        if ($user->exp - $amount >= 0) {
            $user->exp -= $amount;
        } else {
            while ($amount > 0 && $user->level > 0) {
                $user->level -= 1;
                $user->exp_next_level -= 50;

                $amount -= $user->exp;
                $user->exp = $user->exp_next_level - $amount;

                if ($user->exp < 0) {
                    $amount -= $user->exp;
                    $user->exp = 0;
                }
            }
        }

        $user->save();
    }
}
