<?php

namespace App\Http\Controllers;

use App\Models\Rotable;
use App\Models\Supplier;
use App\Models\ShelfLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $storeOfficers = User::role('Store-Manager')->get();
        return view('rotables.create', compact('suppliers', 'locations', 'storeOfficers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'serial_number' => 'required|string',
            'received_quantity' => 'required|integer',
            'accepted_quantity' => 'required|integer',
            'binned_quantity' => 'required|integer',
            'ak_reg' => 'required|string',
            'remark' => 'nullable|string',
            'store_officer_id' => 'required|exists:users,id',
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
        $storeOfficers = User::role('Store-Manager')->get();
        return view('rotables.edit', compact('rotable', 'suppliers', 'locations', 'storeOfficers'));
    }

    public function update(Request $request, Rotable $rotable)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'serial_number' => 'required|string',
            'received_quantity' => 'required|integer',
            'accepted_quantity' => 'required|integer',
            'binned_quantity' => 'required|integer',
            'ak_reg' => 'required|string',
            'remark' => 'nullable|string',
            'store_officer_id' => 'required|exists:users,id',
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
