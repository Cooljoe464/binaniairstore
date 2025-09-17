<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\Tool;
use App\Models\Supplier;
use App\Models\ShelfLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ToolController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:tools-list', ['only' => ['index']]);
//        $this->middleware('permission:tools-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:tools-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:tools-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('tools.index');
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $aircrafts = Aircraft::all();
        return view('tools.create', compact('suppliers', 'locations', 'aircrafts'));
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
            'status' => 'required|string',
            'calibration_date' => 'required|date',
            'due_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            Tool::create($request->merge([
                'received_by_id' => Auth::id(),
            ])->all());
        });

        return redirect()->route('tools.index')->with('success', 'Tool created successfully.');
    }

    public function edit(Tool $tool)
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $aircrafts = Aircraft::all();
        return view('tools.edit', compact('tool', 'suppliers', 'locations', 'aircrafts'));
    }

    public function update(Request $request, Tool $tool)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'serial_number' => 'required|string',
            'quantity' => 'required|integer',
            'aircraft_registration' => 'required|string',
            'remark' => 'nullable|string',
            'status' => 'required|string',
            'calibration_date' => 'required|date',
            'due_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $tool) {
            $tool->update($request->merge([
                'received_by_id' => Auth::id(),
            ])->all());
        });

        return redirect()->route('tools.index')->with('success', 'Tool updated successfully.');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();
        return redirect()->route('tools.index')->with('success', 'Tool deleted successfully.');
    }
}
