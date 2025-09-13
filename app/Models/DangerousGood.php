<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DangerousGood extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'part_number',
        'description',
        'serial_number',
        'received_quantity',
        'accepted_quantity',
        'binned_quantity',
        'ak_reg',
        'remark',
        'store_officer_id',
        'status',
        'airway_bill',
        'supplier_id',
        'location_id',
        'received_date',
        'due_date',
    ];

    protected $casts = [
        'status' => Status::class,
        'received_date' => 'date',
        'due_date' => 'date',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(ShelfLocation::class, 'location_id');
    }

    public function storeOfficer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'store_officer_id');
    }
}
