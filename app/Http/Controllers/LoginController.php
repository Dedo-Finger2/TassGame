<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view("auth.register");
    }


    public function store(Request $request)
    {
        $credenciais = $request->validate([
            'name'     => ['required', 'string' ],
            'email'    => ['required', 'email' , 'unique:users'],
            'password' => ['required', 'min:3' ],
        ]);

        $user = User::create($credenciais);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Register done!');

    }


    public function login()
    {
        return view("auth.login");
    }


    public function auth(Request $request)
    {
        $credenciais = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:3'],
        ]);

        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Logged in!');
        }

        return redirect()->back()->with('error', 'Email or Password incorrect');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
