<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use App\Models\ShelfLocation;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    public function index()
    {
        return view('shelves.index');
    }

    public function create()
    {
        $shelfLocations = ShelfLocation::all();
        return view('shelves.create', compact('shelfLocations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'shelf_location_id' => 'required|exists:shelf_locations,id',
        ]);

        Shelf::create($request->all());

        return redirect()->route('shelves.index')->with('success', 'Shelf created successfully.');
    }

    public function edit(Shelf $shelf)
    {
        $shelfLocations = ShelfLocation::all();
        return view('shelves.edit', compact('shelf', 'shelfLocations'));
    }

    public function update(Request $request, Shelf $shelf)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'shelf_location_id' => 'required|exists:shelf_locations,id',
        ]);

        $shelf->update($request->all());

        return redirect()->route('shelves.index')->with('success', 'Shelf updated successfully.');
    }

    public function destroy(Shelf $shelf)
    {
        $shelf->delete();

        return redirect()->route('shelves.index')->with('success', 'Shelf deleted successfully.');
    }
}
