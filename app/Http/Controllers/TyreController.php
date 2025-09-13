<?php

namespace App\Http\Controllers;

use App\Models\Tyre;
use App\Models\Supplier;
use App\Models\ShelfLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TyreController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:tyres-list', ['only' => ['index']]);
//        $this->middleware('permission:tyres-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:tyres-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:tyres-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('tyres.index');
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $users = User::all();
        return view('tyres.create', compact('suppliers', 'locations', 'users'));
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
            'received_by_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            Tyre::create($request->all());
        });

        return redirect()->route('tyres.index')->with('success', 'Tyre created successfully.');
    }

    public function edit(Tyre $tyre)
    {
        $suppliers = Supplier::all();
        $locations = ShelfLocation::all();
        $users = User::all();
        return view('tyres.edit', compact('tyre', 'suppliers', 'locations', 'users'));
    }

    public function update(Request $request, Tyre $tyre)
    {
        $request->validate([
            'part_number' => 'required|string',
            'description' => 'nullable|string',
            'serial_number' => 'required|string',
            'quantity_received' => 'required|integer',
            'status' => 'required|string',
            'airway_bill' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'received_by_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:shelf_locations,id',
            'date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $tyre) {
            $tyre->update($request->all());
        });

        return redirect()->route('tyres.index')->with('success', 'Tyre updated successfully.');
    }

    public function destroy(Tyre $tyre)
    {
        $tyre->delete();
        return redirect()->route('tyres.index')->with('success', 'Tyre deleted successfully.');
    }
}
