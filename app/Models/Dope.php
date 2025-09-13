<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dope extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'part_number',
        'description',
        'quantity_received',
        'status',
        'supplier_id',
        'airway_bill',
        'location_id',
        'received_by_id',
        'date',
    ];

    protected $casts = [
        'status' => Status::class,
        'date' => 'date',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(ShelfLocation::class, 'location_id');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by_id');
    }
}
