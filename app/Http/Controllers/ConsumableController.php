<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\Consumable;
use App\Models\ShelfLocation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ConsumableController extends Controller
{
    public function index()
    {
        return view('consumables.index');
    }

    public function create()
    {
        $aircrafts = Aircraft::all();
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        return view('consumables.create', compact('aircrafts', 'suppliers', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'serial_number' => 'required|string',
            'quantity' => 'required|integer',
            'aircraft_registration' => 'required|string',
            'remark' => 'nullable|string',
            'aircraft_id' => 'required|exists:aircraft,id',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'airway_bill' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'received_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            Consumable::create($request->merge([
                'received_by_id' => Auth::id(),
            ])->all());
        });

        return redirect()->route('consumables.index')->with('success', 'Consumable created successfully.');
    }

    public function edit(Consumable $consumable)
    {
        $aircrafts = Aircraft::all();
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        return view('consumables.edit', compact('consumable', 'aircrafts', 'suppliers', 'locations'));
    }

    public function update(Request $request, Consumable $consumable)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'serial_number' => 'required|string',
            'quantity' => 'required|integer',
            'aircraft_registration' => 'required|string',
            'remark' => 'nullable|string',
            'aircraft_id' => 'required|exists:aircraft,id',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'airway_bill' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'received_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $consumable) {
            $consumable->update($request->merge([
                'received_by_id' => Auth::id(),
            ])->all());
        });

        return redirect()->route('consumables.index')->with('success', 'Consumable updated successfully.');
    }

    public function destroy(Consumable $consumable)
    {
        $consumable->delete();
        return redirect()->route('consumables.index')->with('success', 'Consumable deleted successfully.');
    }
}
