<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\DangerousGood;
use App\Models\Supplier;
use App\Models\ShelfLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $aircrafts = Aircraft::all();
        return view('dangerous-goods.create', compact('suppliers', 'locations', 'aircrafts'));
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
            'airway_bill' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'received_date' => 'required|date',
            'due_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            DangerousGood::create($request->merge(['received_by_id' => Auth::id()])->all());
        });

        return redirect()->route('dangerous-goods.index')->with('success', 'Dangerous Good created successfully.');
    }

    public function edit(DangerousGood $dangerousGood)
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $aircrafts = Aircraft::all();
        return view('dangerous-goods.edit', compact('dangerousGood', 'suppliers', 'locations', 'aircrafts'));
    }

    public function update(Request $request, DangerousGood $dangerousGood)
    {
        $request->validate([
            'part_number' => 'required|string',
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
            'due_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $dangerousGood) {
            $dangerousGood->update($request->merge(['received_by_id' => Auth::id()])->all());
        });

        return redirect()->route('dangerous-goods.index')->with('success', 'Dangerous Good updated successfully.');
    }

    public function destroy(DangerousGood $dangerousGood)
    {
        $dangerousGood->delete();
        return redirect()->route('dangerous-goods.index')->with('success', 'Dangerous Good deleted successfully.');
    }
}
