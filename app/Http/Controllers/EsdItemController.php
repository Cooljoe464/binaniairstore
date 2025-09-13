<?php

namespace App\Http\Controllers;

use App\Models\EsdItem;
use App\Models\Supplier;
use App\Models\ShelfLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EsdItemController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:esd-items-list', ['only' => ['index']]);
//        $this->middleware('permission:esd-items-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:esd-items-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:esd-items-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('esd-items.index');
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $storeOfficers = User::role('Store-Manager')->get();
        return view('esd-items.create', compact('suppliers', 'locations', 'storeOfficers'));
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
            EsdItem::create($request->all());
        });

        return redirect()->route('esd-items.index')->with('success', 'ESD Item created successfully.');
    }

    public function edit(EsdItem $esdItem)
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $storeOfficers = User::role('Store-Manager')->get();
        return view('esd-items.edit', compact('esdItem', 'suppliers', 'locations', 'storeOfficers'));
    }

    public function update(Request $request, EsdItem $esdItem)
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

        DB::transaction(function () use ($request, $esdItem) {
            $esdItem->update($request->all());
        });

        return redirect()->route('esd-items.index')->with('success', 'ESD Item updated successfully.');
    }

    public function destroy(EsdItem $esdItem)
    {
        $esdItem->delete();
        return redirect()->route('esd-items.index')->with('success', 'ESD Item deleted successfully.');
    }
}
