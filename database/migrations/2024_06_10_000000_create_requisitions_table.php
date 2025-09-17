<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\RequisitionStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('requisition_no')->unique();
            $table->uuid('part_id');
            $table->string('part_type');
            $table->foreignUuid('aircraft_id')->nullable()->constrained('aircrafts');
            $table->string('serial_number')->nullable();
            $table->unsignedInteger('quantity_required');
            $table->unsignedInteger('quantity_issued')->default(0);
            $table->string('stores_batch_number')->nullable();
            $table->string('collectors_name');
            $table->text('additional_notes')->nullable();
            $table->foreignUuid('location_to_id')->constrained('locations');
            $table->foreignUuid('issued_by_id')->constrained('users');
            $table->string('requested_by');
            $table->foreignUuid('approved_by_id')->nullable()->constrained('users');
            $table->foreignUuid('disbursed_by_id')->nullable()->constrained('users');

            $table->string('status')->default(RequisitionStatus::PENDING_APPROVAL->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisitions');
    }
};
