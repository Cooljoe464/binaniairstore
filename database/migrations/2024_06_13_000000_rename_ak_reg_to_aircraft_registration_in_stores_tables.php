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
            $table->renameColumn('ak_reg', 'aircraft_registration');
        });

        Schema::table('consumables', function (Blueprint $table) {
            $table->renameColumn('ak_reg', 'aircraft_registration');
        });

        Schema::table('esd_items', function (Blueprint $table) {
            $table->renameColumn('ak_reg', 'aircraft_registration');
        });

        Schema::table('dangerous_goods', function (Blueprint $table) {
            $table->renameColumn('ak_reg', 'aircraft_registration');
        });

        Schema::table('tyres', function (Blueprint $table) {
            $table->renameColumn('ak_reg', 'aircraft_registration');
        });

        Schema::table('tools', function (Blueprint $table) {
            $table->renameColumn('ak_reg', 'aircraft_registration');
        });

        Schema::table('dopes', function (Blueprint $table) {
            $table->renameColumn('ak_reg', 'aircraft_registration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rotables', function (Blueprint $table) {
            $table->renameColumn('aircraft_registration', 'ak_reg');
        });

        Schema::table('consumables', function (Blueprint $table) {
            $table->renameColumn('aircraft_registration', 'ak_reg');
        });

        Schema::table('esd_items', function (Blueprint $table) {
            $table->renameColumn('aircraft_registration', 'ak_reg');
        });

        Schema::table('dangerous_goods', function (Blueprint $table) {
            $table->renameColumn('aircraft_registration', 'ak_reg');
        });

        Schema::table('tyres', function (Blueprint $table) {
            $table->renameColumn('aircraft_registration', 'ak_reg');
        });

        Schema::table('tools', function (Blueprint $table) {
            $table->renameColumn('aircraft_registration', 'ak_reg');
        });

        Schema::table('dopes', function (Blueprint $table) {
            $table->renameColumn('aircraft_registration', 'ak_reg');
        });
    }
};
