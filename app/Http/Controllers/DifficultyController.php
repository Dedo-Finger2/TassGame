<?php

namespace App\Http\Controllers;

use App\Models\Difficulty;
use Illuminate\Http\Request;

class DifficultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $difficulties = Difficulty::all();

        return view('difficulty.index', [
            'difficulties' => $difficulties,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('difficulty.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'unique:difficulties'],
            'exp'         => ['required', 'numeric', 'min:1'],
            'coins'       => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'string', 'min:3'],
        ]);

        Difficulty::create($data);

        return redirect()->route('difficulties.index')->with('success', 'New urgence added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Difficulty $difficulty)
    {
        return view('difficulty.show', [
            'difficulty' => $difficulty,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Difficulty $difficulty)
    {
        return view('difficulty.edit', [
            'difficulty' => $difficulty,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Difficulty $difficulty)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'unique:difficulties,name,' . $difficulty->id,],
            'exp'         => ['required', 'numeric', 'min:1'],
            'coins'       => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'string', 'min:3'],
        ]);

        try {
            $difficulty->update($data);
            return redirect()->route('difficulties.index')->with('success', 'Difficulty updated!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Difficulty $difficulty)
    {
        try {
            $difficulty->delete();
            return redirect()->route('difficulties.index')->with('success', 'Difficulty deleted!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
