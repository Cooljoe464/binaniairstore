<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consumable extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'part_number',
        'description',
        'received_quantity',
        'accepted_quantity',
        'binned_quantity',
        'ak_reg',
        'remark',
        'store_officer_id',
        'aircraft_id',
        'due_date',
        'received_by_id',
        'status',
        'supplier_id',
        'location_id',
        'received_date',
    ];

    protected $casts = [
        'status' => Status::class,
        'due_date' => 'date',
        'received_date' => 'date',
    ];

    public function aircraft(): BelongsTo
    {
        return $this->belongsTo(Aircraft::class);
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by_id');
    }

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
