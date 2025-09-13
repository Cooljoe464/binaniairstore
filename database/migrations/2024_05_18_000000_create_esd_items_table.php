<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('esd_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('part_number');
            $table->text('description')->nullable();
            $table->string('serial_number');
            $table->integer('quantity_received');
            $table->string('status');
            $table->string('airway_bill')->nullable();
            $table->foreignUuid('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('location_id')->constrained('shelf_locations')->cascadeOnDelete();
            $table->date('received_date');
            $table->timestamps();

            $table->unique(['part_number', 'serial_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esd_items');
    }
};
