<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\Consumable;
use App\Models\ShelfLocation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsumableController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:consumables-list', ['only' => ['index']]);
//        $this->middleware('permission:consumables-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:consumables-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:consumables-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('consumables.index');
    }

    public function create()
    {
        $aircrafts = Aircraft::all();
        $users = User::all();
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $storeOfficers = User::role('Store-Manager')->get();
        return view('consumables.create', compact('aircrafts', 'users', 'suppliers', 'locations', 'storeOfficers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'received_quantity' => 'required|integer',
            'accepted_quantity' => 'required|integer',
            'binned_quantity' => 'required|integer',
            'ak_reg' => 'required|string',
            'remark' => 'nullable|string',
            'store_officer_id' => 'required|exists:users,id',
            'aircraft_id' => 'required|exists:aircrafts,id',
            'due_date' => 'required|date',
            'received_by_id' => 'required|exists:users,id',
            'status' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'received_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            Consumable::create($request->all());
        });

        return redirect()->route('consumables.index')->with('success', 'Consumable created successfully.');
    }

    public function edit(Consumable $consumable)
    {
        $aircrafts = Aircraft::all();
        $users = User::all();
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $storeOfficers = User::role('Store-Manager')->get();
        return view('consumables.edit', compact('consumable', 'aircrafts', 'users', 'suppliers', 'locations', 'storeOfficers'));
    }

    public function update(Request $request, Consumable $consumable)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'received_quantity' => 'required|integer',
            'accepted_quantity' => 'required|integer',
            'binned_quantity' => 'required|integer',
            'ak_reg' => 'required|string',
            'remark' => 'nullable|string',
            'store_officer_id' => 'required|exists:users,id',
            'aircraft_id' => 'required|exists:aircrafts,id',
            'due_date' => 'required|date',
            'received_by_id' => 'required|exists:users,id',
            'status' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'received_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $consumable) {
            $consumable->update($request->all());
        });

        return redirect()->route('consumables.index')->with('success', 'Consumable updated successfully.');
    }

    public function destroy(Consumable $consumable)
    {
        $consumable->delete();
        return redirect()->route('consumables.index')->with('success', 'Consumable deleted successfully.');
    }
}
