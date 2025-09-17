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
        Schema::table('rotables', function (Blueprint $table) {
            $table->renameColumn('received_quantity', 'quantity');
        });

        Schema::table('consumables', function (Blueprint $table) {
            $table->renameColumn('received_quantity', 'quantity');
        });

        Schema::table('esd_items', function (Blueprint $table) {
            $table->renameColumn('received_quantity', 'quantity');
        });

        Schema::table('dangerous_goods', function (Blueprint $table) {
            $table->renameColumn('received_quantity', 'quantity');
        });

        Schema::table('tyres', function (Blueprint $table) {
            $table->renameColumn('received_quantity', 'quantity');
        });

        Schema::table('tools', function (Blueprint $table) {
            $table->renameColumn('received_quantity', 'quantity');
        });

        Schema::table('dopes', function (Blueprint $table) {
            $table->renameColumn('received_quantity', 'quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rotables', function (Blueprint $table) {
            $table->renameColumn('quantity', 'received_quantity');
        });

        Schema::table('consumables', function (Blueprint $table) {
            $table->renameColumn('quantity', 'received_quantity');
        });

        Schema::table('esd_items', function (Blueprint $table) {
            $table->renameColumn('quantity', 'received_quantity');
        });

        Schema::table('dangerous_goods', function (Blueprint $table) {
            $table->renameColumn('quantity', 'received_quantity');
        });

        Schema::table('tyres', function (Blueprint $table) {
            $table->renameColumn('quantity', 'received_quantity');
        });

        Schema::table('tools', function (Blueprint $table) {
            $table->renameColumn('quantity', 'received_quantity');
        });

        Schema::table('dopes', function (Blueprint $table) {
            $table->renameColumn('quantity', 'received_quantity');
        });
    }
};
