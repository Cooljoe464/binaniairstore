<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AircraftController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:aircrafts-list', ['only' => ['index']]);
//        $this->middleware('permission:aircrafts-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:aircrafts-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:aircrafts-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('aircraft.index');
    }

    public function create()
    {
        return view('aircraft.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:aircraft,name',
        ]);

        DB::transaction(function () use ($request) {
            Aircraft::create($request->all());
        });

        return redirect()->route('aircraft.index')->with('success', 'Aircraft created successfully.');
    }

    public function edit(Aircraft $aircraft)
    {
        return view('aircraft.edit', compact('aircraft'));
    }

    public function update(Request $request, Aircraft $aircraft)
    {
        $request->validate([
            'name' => 'required|string|unique:aircraft,name,' . $aircraft->id,
        ]);

        DB::transaction(function () use ($request, $aircraft) {
            $aircraft->update($request->all());
        });

        return redirect()->route('aircraft.index')->with('success', 'Aircraft updated successfully.');
    }

    public function destroy(Aircraft $aircraft)
    {
        $aircraft->delete();
        return redirect()->route('aircraft.index')->with('success', 'Aircraft deleted successfully.');
    }
}
