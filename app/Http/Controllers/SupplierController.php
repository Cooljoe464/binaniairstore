<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:suppliers-list', ['only' => ['index']]);
//        $this->middleware('permission:suppliers-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:suppliers-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:suppliers-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('suppliers.index');
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:suppliers,name',
            'contact_person' => 'nullable|string',
            'email' => 'required|string|email|unique:suppliers,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            Supplier::create($request->all());
        });

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|unique:suppliers,name,' . $supplier->id,
            'contact_person' => 'nullable|string',
            'email' => 'required|string|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $supplier) {
            $supplier->update($request->all());
        });

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
