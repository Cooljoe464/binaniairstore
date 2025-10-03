<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\RequisitionStatus;
use App\Models\User;
use App\Models\Aircraft;
use App\Models\Location;
use App\Models\Rotable;
use App\Models\Consumable;
use App\Models\EsdItem;
use App\Models\DangerousGood;
use App\Models\Tyre;
use App\Models\Tool;
use App\Models\Dope;
use App\Notifications\RequisitionApproved;
use App\Notifications\RequisitionDisbursed;
use App\Notifications\RequisitionRejected;
use App\Notifications\NewRequisition;
use Illuminate\Support\Facades\Log;

class RequisitionController extends Controller
{
    public function index()
    {
        return view('requisitions.index');
    }

    public function create()
    {
        $aircrafts = Aircraft::all();
        $locations = Location::all();
        $parts = Rotable::all()->concat(Consumable::all())->concat(EsdItem::all())->concat(DangerousGood::all())->concat(Tyre::all())->concat(Tool::all())->concat(Dope::all());

        return view('requisitions.create', compact('aircrafts', 'locations', 'parts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_id' => 'required',
            'aircraft_registration' => 'nullable|string|exists:aircraft,registration_number',
            'quantity_required' => 'required|integer|min:1',
            'quantity_issued' => 'required|integer|min:0|lte:quantity_required',
            'collectors_name' => 'required|string|max:255',
            'location_to_id' => 'required',
            'requested_by' => 'required|string',
        ]);

        $partId = $request->input('part_id');
        $part = null;
        $part_type = null;
        $part_models = [Rotable::class, Consumable::class, EsdItem::class, DangerousGood::class, Tyre::class, Tool::class, Dope::class];
        foreach ($part_models as $model) {
            $part = $model::find($partId);
            if ($part) {
                $part_type = $model;
                break;
            }
        }

        if (!$part) {
            return back()->withErrors(['part_id' => 'The selected part is invalid.'])->withInput();
        }

        $stock_balance = $part->quantity;
        $new_stock_balance = $stock_balance - $request->quantity_issued;

        $lastRequisition = Requisition::latest('id')->first();
        $nextRequisitionNumber = $lastRequisition ? ((int) substr($lastRequisition->requisition_no, -4)) + 1 : 1;
        $requisition_no = 'BGAS-SR-' . str_pad($nextRequisitionNumber, 4, '0', STR_PAD_LEFT);

        $requisition = Requisition::create([
            'requisition_no' => $requisition_no,
            'part_id' => $part->id,
            'part_type' => $part_type,
            'aircraft_registration' => $request->aircraft_registration,
            'serial_number' => $request->serial_number,
            'quantity_required' => $request->quantity_required,
            'quantity_issued' => $request->quantity_issued,
            'stock_balance' => $stock_balance,
            'new_stock_balance' => $new_stock_balance,
            'collectors_name' => $request->collectors_name,
            'additional_notes' => $request->additional_notes,
            'location_to_id' => $request->location_to_id,
            'requested_by' => $request->requested_by,
            'issued_by_id' => auth()->id(),
            'status' => RequisitionStatus::PENDING_APPROVAL,
        ]);

        try {
            $mds = User::role('MD')->get();
            foreach ($mds as $md) {
                $md->notify(new NewRequisition($requisition));
            }
            session()->flash('notification_success', 'Notification sent successfully.');
        } catch (\Exception $e) {
            Log::error('Notification sending failed: ' . $e->getMessage());
            session()->flash('notification_error', 'Failed to send notification.');
        }

        return redirect()->route('requisitions.index')->with('success', 'Requisition created successfully.');
    }

    public function show(Requisition $requisition)
    {
        $users = User::role(['Store-Manager', 'Technician'])->get();
        return view('requisitions.show', compact('requisition', 'users'));
    }

    public function edit(Requisition $requisition)
    {
        $aircrafts = Aircraft::all();
        $locations = Location::all();
        $parts = Rotable::all()->concat(Consumable::all())->concat(EsdItem::all())->concat(DangerousGood::all())->concat(Tyre::all())->concat(Tool::all())->concat(Dope::all());

        return view('requisitions.edit', compact('requisition', 'aircrafts', 'locations', 'parts'));
    }

    public function update(Request $request, Requisition $requisition)
    {
        $request->validate([
            'part_id' => 'required',
            'aircraft_registration' => 'nullable|string|exists:aircraft,registration_number',
            'quantity_required' => 'required|integer|min:1',
            'quantity_issued' => 'required|integer|min:0|lte:quantity_required',
            'collectors_name' => 'required|string|max:255',
            'location_to_id' => 'required',
        ]);

        $partId = $request->input('part_id');
        $part = null;
        $part_type = null;
        $part_models = [Rotable::class, Consumable::class, EsdItem::class, DangerousGood::class, Tyre::class, Tool::class, Dope::class];
        foreach ($part_models as $model) {
            $part = $model::find($partId);
            if ($part) {
                $part_type = $model;
                break;
            }
        }

        if (!$part) {
            return back()->withErrors(['part_id' => 'The selected part is invalid.'])->withInput();
        }

        $stock_balance = $part->quantity;
        $new_stock_balance = $stock_balance - $request->quantity_issued;

        $requisitionData = $request->all();
        $requisitionData['part_id'] = $part->id;
        $requisitionData['part_type'] = $part_type;
        $requisitionData['stock_balance'] = $stock_balance;
        $requisitionData['new_stock_balance'] = $new_stock_balance;

        $isQuantityChanged = (int)$requisition->quantity_required !== (int)$request->quantity_required || (int)$requisition->quantity_issued !== (int)$request->quantity_issued;

        if ($isQuantityChanged) {
            $requisitionData['status'] = RequisitionStatus::PENDING_APPROVAL;
        }

        $requisition->update($requisitionData);

        if ($isQuantityChanged) {
            try {
                $mds = User::role('MD')->get();
                foreach ($mds as $md) {
                    $md->notify(new NewRequisition($requisition));
                }
                session()->flash('notification_success', 'Notification sent successfully.');
            } catch (\Exception $e) {
                Log::error('Notification sending failed: ' . $e->getMessage());
                session()->flash('notification_error', 'Failed to send notification.');
            }
        }

        return redirect()->route('requisitions.index')->with('success', 'Requisition updated successfully.');
    }

    public function destroy(Requisition $requisition)
    {
        $requisition->delete();

        return redirect()->route('requisitions.index')->with('success', 'Requisition deleted successfully.');
    }

    public function approve(Requisition $requisition)
    {
        try {
            DB::transaction(function () use ($requisition) {
                $part = $requisition->part;

                if (!$part) {
                    throw new \Exception('The part associated with this requisition could not be found.');
                }

                if ($part->quantity < $requisition->quantity_issued) {
                    throw new \Exception('Not enough stock available. Only ' . $part->quantity . ' items remaining.');
                }

                $requisition->update([
                    'status' => RequisitionStatus::APPROVED,
                    'approved_by_id' => auth()->id(),
                ]);

                if ($requisition->quantity_issued > 0) {
                    $part->decrement('quantity', $requisition->quantity_issued);
                }
            });

            try {
                $requisition->issuedBy->notify(new RequisitionApproved($requisition));
                session()->flash('notification_success', 'Approval notification sent successfully.');
            } catch (\Exception $e) {
                Log::error('Notification sending failed: ' . $e->getMessage());
                session()->flash('notification_error', 'Failed to send approval notification.');
            }

            return redirect()->route('requisitions.show', $requisition)->with('success', 'Requisition approved and stock updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(Requisition $requisition)
    {
        $requisition->update(['status' => RequisitionStatus::REJECTED]);

        try {
            $requisition->requestedBy->notify(new RequisitionRejected($requisition));
            session()->flash('notification_success', 'Rejection notification sent successfully.');
        } catch (\Exception $e) {
            Log::error('Notification sending failed: ' . $e->getMessage());
            session()->flash('notification_error', 'Failed to send rejection notification.');
        }

        return redirect()->route('requisitions.show', $requisition)->with('success', 'Requisition rejected.');
    }

    public function disburse(Request $request, Requisition $requisition)
    {
        $request->validate([
            'disbursed_by_id' => 'required|exists:users,id',
        ]);

        $requisition->update([
            'disbursed_by_id' => $request->disbursed_by_id,
            'disbursed_at' => now(),
            'status' => RequisitionStatus::DISBURSED,
        ]);

        try {
            $requisition->requestedBy->notify(new RequisitionDisbursed($requisition));
            session()->flash('notification_success', 'Disbursement notification sent successfully.');
        } catch (\Exception $e) {
            Log::error('Notification sending failed: ' . $e->getMessage());
            session()->flash('notification_error', 'Failed to send disbursement notification.');
        }

        return redirect()->route('requisitions.show', $requisition)->with('success', 'Requisition disbursed successfully.');
    }
}
