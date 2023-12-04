<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();

        return view('item.index', [
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'unique:items'],
            'price'       => ['required', 'numeric', 'min:1'],
            'description' => ['string', 'min:3'],
        ]);

        Item::create($data);

        return redirect()->route('items.index')->with('success', 'New item added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('item.show', [
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('item.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'unique:items,name,' . $item->id,],
            'price'       => ['required', 'numeric', 'min:1'],
            'description' => ['string', 'min:3'],
        ]);

        try {
            $item->update($data);
            return redirect()->route('items.index')->with('success', 'Item updated!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        try {
            $item->delete();
            return redirect()->route('items.index')->with('success', 'Item deleted!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
