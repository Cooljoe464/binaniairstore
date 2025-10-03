<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RequisitionStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Requisition extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'requisition_no',
        'part_id',
        'part_type',
        'aircraft_registration',
        'serial_number',
        'quantity_required',
        'quantity_issued',
        'stock_balance',
        'new_stock_balance',
        'stores_batch_number',
        'collectors_name',
        'additional_notes',
        'location_to_id',
        'requested_by',
        'approved_by_id',
        'disbursed_by_id',
        'disbursed_at',
        'issued_by_id',
        'status',
    ];

    protected $casts = [
        'status' => RequisitionStatus::class,
        'disbursed_at' => 'datetime',
    ];

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function disbursedBy()
    {
        return $this->belongsTo(User::class, 'disbursed_by_id');
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by_id');
    }

    public function locationTo()
    {
        return $this->belongsTo(Location::class, 'location_to_id');
    }

    public function part()
    {
        return $this->morphTo();
    }
}
