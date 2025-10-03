<?php

namespace App\Http\Controllers;

use App\Enums\GoodsReceivedNoteStatus;
use App\Models\Consumable;
use App\Models\DangerousGood;
use App\Models\Dope;
use App\Models\EsdItem;
use App\Models\GoodsReceivedNote;
use App\Models\Rotable;
use App\Models\Supplier;
use App\Models\Tool;
use App\Models\Tyre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsReceivedNoteController extends Controller
{
    public function index()
    {
        return view('goods-received-notes.index');
    }

    public function create()
    {
        $users = User::all();
        $suppliers = Supplier::all();
        $parts = Rotable::all()->concat(Consumable::all())->concat(EsdItem::all())->concat(DangerousGood::all())->concat(Tyre::all())->concat(Tool::all())->concat(Dope::all());
        return view('goods-received-notes.create', compact('users', 'suppliers', 'parts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gr_details' => 'required|string',
            'gr_date' => 'required|date',
            'gr_type' => 'required|string',
            'order_info' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'order_details' => 'required|string',
            'waybill' => 'required|string',
            'part_id' => 'required',
            'received_quantity' => 'required|integer',
            'accepted_quantity' => 'required|integer',
            'binned_quantity' => 'required|integer',
            'remark' => 'required|string',
            'date' => 'required|date',
            'store_officer_id' => 'required|exists:users,id',
            'received_by_id' => 'required|exists:users,id',
            'inspected_by_id' => 'required|exists:users,id',
            'binned_by_id' => 'required|exists:users,id',
        ]);

        $partId = $request->input('part_id');
        $part = null;
        $part_models = [Rotable::class, Consumable::class, EsdItem::class, DangerousGood::class, Tyre::class, Tool::class, Dope::class];
        foreach ($part_models as $model) {
            $part = $model::find($partId);
            if ($part) {
                break;
            }
        }

        if (!$part) {
            return back()->withErrors(['part_id' => 'The selected part is invalid.'])->withInput();
        }

        $supplier = Supplier::find($request->input('supplier_id'));

        $data = $request->except(['part_id', 'supplier_id', 'approved_by_id']);
        $data['part_number'] = $part->part_number;
        $data['description'] = $part->description;
        $data['serial_no'] = $part->serial_number ?? 'N/A';
        $data['supplier_name'] = $supplier->name;

        GoodsReceivedNote::create($data);

        return redirect()->route('goods-received-notes.index')->with('success', 'Goods Received Note created and is pending approval.');
    }

    public function show(GoodsReceivedNote $goodsReceivedNote)
    {
        return view('goods-received-notes.show', compact('goodsReceivedNote'));
    }

    public function edit(GoodsReceivedNote $goodsReceivedNote)
    {
        $users = User::all();
        $suppliers = Supplier::all();
        $parts = Rotable::all()->concat(Consumable::all())->concat(EsdItem::all())->concat(DangerousGood::all())->concat(Tyre::all())->concat(Tool::all())->concat(Dope::all());
        return view('goods-received-notes.edit', compact('goodsReceivedNote', 'users', 'suppliers', 'parts'));
    }

    public function update(Request $request, GoodsReceivedNote $goodsReceivedNote)
    {
        $request->validate([
            'gr_details' => 'required|string',
            'gr_date' => 'required|date',
            'gr_type' => 'required|string',
            'order_info' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'order_details' => 'required|string',
            'waybill' => 'required|string',
            'part_id' => 'required',
            'received_quantity' => 'required|integer',
            'accepted_quantity' => 'required|integer',
            'binned_quantity' => 'required|integer',
            'remark' => 'required|string',
            'date' => 'required|date',
            'store_officer_id' => 'required|exists:users,id',
            'received_by_id' => 'required|exists:users,id',
            'inspected_by_id' => 'required|exists:users,id',
            'binned_by_id' => 'required|exists:users,id',
        ]);

        $partId = $request->input('part_id');
        $part = null;
        $part_models = [Rotable::class, Consumable::class, EsdItem::class, DangerousGood::class, Tyre::class, Tool::class, Dope::class];
        foreach ($part_models as $model) {
            $part = $model::find($partId);
            if ($part) {
                break;
            }
        }

        if (!$part) {
            return back()->withErrors(['part_id' => 'The selected part is invalid.'])->withInput();
        }

        $supplier = Supplier::find($request->input('supplier_id'));

        $data = $request->except(['part_id', 'supplier_id', 'approved_by_id']);
        $data['part_number'] = $part->part_number;
        $data['description'] = $part->description;
        $data['serial_no'] = $part->serial_number ?? 'N/A';
        $data['supplier_name'] = $supplier->name;
        $data['status'] = GoodsReceivedNoteStatus::PENDING_APPROVAL;

        $goodsReceivedNote->update($data);

        return redirect()->route('goods-received-notes.show', $goodsReceivedNote)->with('success', 'Goods Received Note updated and is pending re-approval.');
    }

    public function destroy(GoodsReceivedNote $goodsReceivedNote)
    {
        $goodsReceivedNote->delete();

        return redirect()->route('goods-received-notes.index')->with('success', 'Goods Received Note deleted successfully.');
    }

    public function approve(GoodsReceivedNote $goodsReceivedNote)
    {
        try {
            DB::transaction(function () use ($goodsReceivedNote) {
                $part = $goodsReceivedNote->part();

                if (!$part) {
                    throw new \Exception('The part associated with this note could not be found.');
                }

                $goodsReceivedNote->update([
                    'status' => GoodsReceivedNoteStatus::APPROVED,
                    'approved_by_id' => auth()->id(),
                ]);

                $part->increment('quantity', $goodsReceivedNote->accepted_quantity);
            });

            return redirect()->route('goods-received-notes.show', $goodsReceivedNote)->with('success', 'Goods Received Note approved and stock updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(GoodsReceivedNote $goodsReceivedNote)
    {
        $goodsReceivedNote->update(['status' => GoodsReceivedNoteStatus::REJECTED]);

        return redirect()->route('goods-received-notes.show', $goodsReceivedNote)->with('success', 'Goods Received Note rejected.');
    }
}
