<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\Rotable;
use App\Models\Supplier;
use App\Models\ShelfLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RotableController extends Controller
{
    public function index()
    {
        return view('rotables.index');
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $aircrafts = Aircraft::all();
        return view('rotables.create', compact('suppliers', 'locations', 'aircrafts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_number' => [
                'required',
                'string',
                Rule::unique('rotables')->where(function ($query) use ($request) {
                    return $query->where('serial_number', $request->serial_number);
                }),
            ],
            'description' => 'nullable|string',
            'serial_number' => 'required|string',
            'quantity' => 'required|integer',
            'aircraft_registration' => 'required|string',
            'remark' => 'nullable|string',
            'status' => 'required|string',
            'airway_bill' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'received_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            Rotable::create($request->merge([
                'received_by_id' => Auth::id(),
            ])->all());
        });

        return redirect()->route('rotables.index')->with('success', 'Rotable created successfully.');
    }

    public function edit(Rotable $rotable)
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $aircrafts = Aircraft::all();
        return view('rotables.edit', compact('rotable', 'suppliers', 'locations', 'aircrafts'));
    }

    public function update(Request $request, Rotable $rotable)
    {
        $request->validate([
            'part_number' => [
                'required',
                'string',
                Rule::unique('rotables')->where(function ($query) use ($request) {
                    return $query->where('serial_number', $request->serial_number);
                })->ignore($rotable->id),
            ],
            'description' => 'nullable|string',
            'serial_number' => 'required|string',
            'quantity' => 'required|integer',
            'aircraft_registration' => 'required|string',
            'remark' => 'nullable|string',
            'status' => 'required|string',
            'airway_bill' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'received_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $rotable) {
            $rotable->update($request->merge([
                'received_by_id' => Auth::id(),
            ])->all());
        });

        return redirect()->route('rotables.index')->with('success', 'Rotable updated successfully.');
    }

    public function destroy(Rotable $rotable)
    {
        $rotable->delete();
        return redirect()->route('rotables.index')->with('success', 'Rotable deleted successfully.');
    }
}
