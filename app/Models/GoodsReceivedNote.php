<?php

namespace App\Models;

use App\Enums\GoodsReceivedNoteStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class GoodsReceivedNote extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'gr_details',
        'gr_date',
        'gr_type',
        'order_info',
        'supplier_name',
        'order_details',
        'waybill',
        'part_number',
        'description',
        'serial_no',
        'received_quantity',
        'accepted_quantity',
        'binned_quantity',
        'remark',
        'date',
        'store_officer_id',
        'aircraft_registration',
        'additional_info',
        'received_by_id',
        'inspected_by_id',
        'binned_by_id',
        // 'approved_by_id' is now handled by the approval workflow
    ];

    protected $casts = [
        'status' => GoodsReceivedNoteStatus::class,
    ];

    public function storeOfficer()
    {
        return $this->belongsTo(User::class, 'store_officer_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by_id');
    }

    public function inspectedBy()
    {
        return $this->belongsTo(User::class, 'inspected_by_id');
    }

    public function binnedBy()
    {
        return $this->belongsTo(User::class, 'binned_by_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function part()
    {
        // Since part_number is stored, we need a way to find the original part.
        // This assumes a unique part_number across all part models.
        // A more robust solution might involve storing part_id and part_type.
        $partModels = [Rotable::class, Consumable::class, EsdItem::class, DangerousGood::class, Tyre::class, Tool::class, Dope::class];
        foreach ($partModels as $model) {
            $part = $model::where('part_number', $this->part_number)->first();
            if ($part) {
                return $part;
            }
        }
        return null;
    }
}
