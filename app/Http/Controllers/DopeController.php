<?php

namespace App\Http\Controllers;

use App\Models\Dope;
use App\Models\Supplier;
use App\Models\ShelfLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DopeController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:dopes-list', ['only' => ['index']]);
//        $this->middleware('permission:dopes-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:dopes-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:dopes-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('dopes.index');
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $users = User::all();
        return view('dopes.create', compact('suppliers', 'locations', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'quantity_received' => 'required|integer',
            'status' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'airway_bill' => 'nullable|string',
            'location_id' => 'required|exists:shelf_locations,id',
            'received_by_id' => 'required|exists:users,id',
            'date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            Dope::create($request->all());
        });

        return redirect()->route('dopes.index')->with('success', 'Dope created successfully.');
    }

    public function edit(Dope $dope)
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $users = User::all();
        return view('dopes.edit', compact('dope', 'suppliers', 'locations', 'users'));
    }

    public function update(Request $request, Dope $dope)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'quantity_received' => 'required|integer',
            'status' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'airway_bill' => 'nullable|string',
            'location_id' => 'required|exists:shelf_locations,id',
            'received_by_id' => 'required|exists:users,id',
            'date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $dope) {
            $dope->update($request->all());
        });

        return redirect()->route('dopes.index')->with('success', 'Dope updated successfully.');
    }

    public function destroy(Dope $dope)
    {
        $dope->delete();
        return redirect()->route('dopes.index')->with('success', 'Dope deleted successfully.');
    }
}
