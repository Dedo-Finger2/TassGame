<?php

namespace App\Http\Controllers;

use App\Models\Importance;
use Illuminate\Http\Request;

class ImportanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $importances = Importance::all();

        return view('importance.index', [
            'importances' => $importances,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('importance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'unique:importances'],
            'exp'         => ['required', 'numeric', 'min:1'],
            'coins'       => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'string', 'min:3'],
        ]);

        Importance::create($data);

        return redirect()->route('importances.index')->with('success', 'New importance added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Importance $importance)
    {
        return view('importance.show', [
            'importance' => $importance,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Importance $importance)
    {
        return view('importance.edit', [
            'importance' => $importance,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Importance $importance)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'unique:importances,name,' . $importance->id,],
            'exp'         => ['required', 'numeric', 'min:1'],
            'coins'       => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'string', 'min:3'],
        ]);

        try {
            $importance->update($data);
            return redirect()->route('importances.index')->with('success', 'Importance updated!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Importance $importance)
    {
        try {
            $importance->delete();
            return redirect()->route('importances.index')->with('success', 'Importance deleted!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
