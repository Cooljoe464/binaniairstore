<?php

namespace App\Http\Controllers;

use App\Models\DangerousGood;
use App\Models\Supplier;
use App\Models\ShelfLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DangerousGoodController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:dangerous-goods-list', ['only' => ['index']]);
//        $this->middleware('permission:dangerous-goods-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:dangerous-goods-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:dangerous-goods-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('dangerous-goods.index');
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $storeOfficers = User::role('Store-Manager')->get();
        return view('dangerous-goods.create', compact('suppliers', 'locations', 'storeOfficers'));
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
            'due_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            DangerousGood::create($request->all());
        });

        return redirect()->route('dangerous-goods.index')->with('success', 'Dangerous Good created successfully.');
    }

    public function edit(DangerousGood $dangerousGood)
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $storeOfficers = User::role('Store-Manager')->get();
        return view('dangerous-goods.edit', compact('dangerousGood', 'suppliers', 'locations', 'storeOfficers'));
    }

    public function update(Request $request, DangerousGood $dangerousGood)
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
            'due_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $dangerousGood) {
            $dangerousGood->update($request->all());
        });

        return redirect()->route('dangerous-goods.index')->with('success', 'Dangerous Good updated successfully.');
    }

    public function destroy(DangerousGood $dangerousGood)
    {
        $dangerousGood->delete();
        return redirect()->route('dangerous-goods.index')->with('success', 'Dangerous Good deleted successfully.');
    }
}
