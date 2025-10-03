<?php

namespace App\Http\Controllers;

use App\Models\ShelfLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShelfLocationController extends Controller
{
    public function index()
    {
        return view('shelf-locations.index');
    }

    public function create()
    {
        return view('shelf-locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:shelf_locations,name',
        ]);

        DB::transaction(function () use ($request) {
            ShelfLocation::create($request->all());
        });

        return redirect()->route('shelf-locations.index')->with('success', 'Shelf location created successfully.');
    }

    public function edit(ShelfLocation $shelfLocation)
    {
        return view('shelf-locations.edit', compact('shelfLocation'));
    }

    public function update(Request $request, ShelfLocation $shelfLocation)
    {
        $request->validate([
            'name' => 'required|string|unique:shelf_locations,name,' . $shelfLocation->id,
        ]);

        DB::transaction(function () use ($request, $shelfLocation) {
            $shelfLocation->update($request->all());
        });

        return redirect()->route('shelf-locations.index')->with('success', 'Shelf location updated successfully.');
    }

    public function destroy(ShelfLocation $shelfLocation)
    {
        $shelfLocation->delete();
        return redirect()->route('shelf-locations.index')->with('success', 'Shelf location deleted successfully.');
    }
}
