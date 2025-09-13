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
        Schema::table('consumables', function (Blueprint $table) {
            $table->renameColumn('quantity_received', 'received_quantity');
            $table->integer('accepted_quantity')->after('received_quantity');
            $table->integer('binned_quantity')->after('accepted_quantity');
            $table->string('ak_reg')->after('binned_quantity');
            $table->text('remark')->nullable()->after('ak_reg');
            $table->foreignUuid('store_officer_id')->nullable()->after('remark')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consumables', function (Blueprint $table) {
            $table->renameColumn('received_quantity', 'quantity_received');
            $table->dropColumn(['accepted_quantity', 'binned_quantity', 'ak_reg', 'remark']);
            $table->dropForeign(['store_officer_id']);
            $table->dropColumn('store_officer_id');
        });
    }
};
