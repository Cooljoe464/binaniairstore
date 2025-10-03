<?php

use App\Enums\GoodsReceivedNoteStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('goods_received_notes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('gr_details');
            $table->date('gr_date');
            $table->string('gr_type');
            $table->string('order_info');
            $table->string('supplier_name');
            $table->string('order_details');
            $table->string('waybill');
            $table->string('part_number');
            $table->text('description');
            $table->string('serial_no');
            $table->integer('received_quantity');
            $table->integer('accepted_quantity');
            $table->integer('binned_quantity');
            $table->text('remark');
            $table->date('date');
            $table->foreignUuid('store_officer_id')->constrained('users');
            $table->string('aircraft_registration')->nullable();
            $table->text('additional_info')->nullable();
            $table->foreignUuid('received_by_id')->constrained('users');
            $table->foreignUuid('inspected_by_id')->constrained('users');
            $table->foreignUuid('binned_by_id')->constrained('users');
            $table->foreignUuid('approved_by_id')->nullable()->constrained('users');
            $table->string('status')->default(GoodsReceivedNoteStatus::PENDING_APPROVAL->value);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('goods_received_notes');
    }
};
