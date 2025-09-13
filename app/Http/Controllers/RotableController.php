<?php

namespace App\Http\Controllers;

use App\Models\Rotable;
use App\Models\Supplier;
use App\Models\ShelfLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @method middleware(string $string, array[] $array)
 */
class RotableController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:rotables-list', ['only' => ['index']]);
//        $this->middleware('permission:rotables-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:rotables-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:rotables-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('rotables.index');
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        return view('rotables.create', compact('suppliers', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'serial_number' => 'required|string',
            'quantity_received' => 'required|integer',
            'status' => 'required|string',
            'airway_bill' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'received_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            Rotable::create($request->all());
        });

        return redirect()->route('rotables.index')->with('success', 'Rotable created successfully.');
    }

    public function edit(Rotable $rotable)
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        return view('rotables.edit', compact('rotable', 'suppliers', 'locations'));
    }

    public function update(Request $request, Rotable $rotable)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'serial_number' => 'required|string',
            'quantity_received' => 'required|integer',
            'status' => 'required|string',
            'airway_bill' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'received_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $rotable) {
            $rotable->update($request->all());
        });

        return redirect()->route('rotables.index')->with('success', 'Rotable updated successfully.');
    }

    public function destroy(Rotable $rotable)
    {
        $rotable->delete();
        return redirect()->route('rotables.index')->with('success', 'Rotable deleted successfully.');
    }
}
