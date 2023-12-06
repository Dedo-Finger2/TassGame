<?php

namespace App\Http\Controllers;

use App\Models\Powerup;
use Illuminate\Http\Request;

class PowerupController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $powerups = Powerup::all();

        return view("powerup.index", [
            'powerups' => $powerups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('powerup.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:powerups'],
            'price' => ['required', 'numeric', 'min:1'],
            'description' => ['string', 'min:3'],
            'type' => ['string'],
            'duration' => ['numeric', 'min:1'],
            'multiplier' => ['numeric', 'min:1.1'],
        ]);

        Powerup::create($data);

        return redirect()->route('powerups.index')->with('success', 'New powerup added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Powerup $powerup) {
        return view('powerup.show', [
            'powerup' => $powerup,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Powerup $powerup) {
        return view('powerup.edit', [
            'powerup' => $powerup,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Powerup $powerup) {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:powerups,name,'.$powerup->id],
            'price' => ['required', 'numeric', 'min:1'],
            'description' => ['string', 'min:3'],
            'type' => ['string'],
            'duration' => ['numeric', 'min:1'],
            'multiplier' => ['numeric', 'min:1.1'],
        ]);

        try {
            $powerup->update($data);
            return redirect()->route('powerups.index')->with('success', 'Powerup updated!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Powerup $powerup) {
        try {
            $powerup->delete();
            return redirect()->route('powerups.index')->with('success', 'Powerup deleted!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
