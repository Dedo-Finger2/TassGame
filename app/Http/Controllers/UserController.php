<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        return view("user.profile", [
            "user"=> $user,
        ]);
    }


    public static function earnCoins(int $amount)
    {
        $user = User::find(auth()->user()->id);

        if ($amount <= 0) return redirect()->back()->with("error","Invalid amount of coins.");

        $user->coins += $amount;
        $user->save();
    }


    public static function earnExp(int $amount)
    {
        $user = User::find(auth()->user()->id);

        if ($amount <= 0) return redirect()->back()->with("error","Invalid amount of coins.");

        if ($user->exp + $amount < $user->exp_next_level) {
            $user->exp += $amount;
        } elseif ($user->exp + $amount >= $user->exp_next_level) {
            $user->level += 1;
            $userTotalExp = $user->exp += $amount;

            $user->exp = $userTotalExp % $user->exp_next_level;

            $user->exp_next_level += 50;
        }

        $user->save();
    }


    public static function loseCoins(int $amount)
    {
        $user = User::find(auth()->user()->id);

        if ($amount <= 0) return redirect()->back()->with("error","Invalid amount of coins.");

        $user->coins -= $amount;
        $user->save();
    }

    // TODO: Concertar, está num loop inifinito
    public static function loseExp(int $amount)
    {
        $user = User::find(auth()->user()->id);

        if ($amount <= 0) return redirect()->back()->with("error","Invalid amount of coins.");

        while ($amount > 0) {
            if ($user->exp >= $amount) {
                $user->exp -= $amount;
                $amount = 0;
            } else {
                $amount -= $user->exp;
                $user->exp = 0;

                if ($user->level > 1) {
                    $user->level -= 1;
                    $user->exp_next_level -= 50;
                    $user->exp = $user->exp_next_level;
                }
            }
        }

        $user->save();
    }

}
