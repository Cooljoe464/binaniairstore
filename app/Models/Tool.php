<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tool extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'part_number',
        'description',
        'serial_number',
        'quantity_received',
        'status',
        'calibration_date',
        'due_date',
        'supplier_id',
        'received_by_id',
        'location_id',
        'date',
    ];

    protected $casts = [
        'status' => Status::class,
        'calibration_date' => 'date',
        'due_date' => 'date',
        'date' => 'date',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(ShelfLocation::class, 'location_id');
    }
}
