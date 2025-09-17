<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:shelf-locations-list', ['only' => ['index']]);
//        $this->middleware('permission:shelf-locations-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:shelf-locations-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:shelf-locations-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::paginate(10);
        return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations',
        ]);

        Location::create($request->all());

        return redirect()->route('locations.index')->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $location->id,
        ]);

        $location->update($request->all());

        return redirect()->route('locations.index')->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('locations.index')->with('success', 'Location deleted successfully.');
    }
}
