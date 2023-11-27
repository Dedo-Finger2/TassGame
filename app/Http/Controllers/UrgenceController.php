<?php

namespace App\Http\Controllers;

use App\Models\Urgence;
use Illuminate\Http\Request;

class UrgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urgences = Urgence::all();

        return view('urgence.index', [
            'urgences' => $urgences,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('urgence.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:urgences'],
            'exp' => ['required', 'numeric', 'min:1'],
            'coins' => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'string', 'min:3'],
        ]);

        Urgence::create($data);

        return redirect()->route('urgences.index')->with('success', 'New urgence added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Urgence $urgence)
    {
        return view('urgence.show', [
            'urgence' => $urgence,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Urgence $urgence)
    {
        return view('urgence.edit', [
            'urgence' => $urgence,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Urgence $urgence)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'unique:urgences,name,' . $urgence->id,],
            'exp'         => ['required', 'numeric', 'min:1'],
            'coins'       => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'string', 'min:3'],
        ]);

        try {
            $urgence->update($data);
            return redirect()->route('urgences.index')->with('success', 'Urgence updated!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Urgence $urgence)
    {
        try {
            $urgence->delete();
            return redirect()->route('urgences.index')->with('success', 'Urgence deleted!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
