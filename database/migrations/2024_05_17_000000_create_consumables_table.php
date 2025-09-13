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
        Schema::create('consumables', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('part_number');
            $table->text('description')->nullable();
            $table->integer('quantity_received');
            $table->foreignUuid('aircraft_id')->constrained()->cascadeOnDelete();
            $table->date('due_date');
            $table->foreignUuid('received_by_id')->constrained('users')->cascadeOnDelete();
            $table->string('status');
            $table->foreignUuid('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('location_id')->constrained('shelf_locations')->cascadeOnDelete();
            $table->date('received_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumables');
    }
};
