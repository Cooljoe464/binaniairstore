<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dopes', function (Blueprint $table) {
            if (!Schema::hasColumn('dopes', 'serial_number')) {
                $table->string('serial_number')->after('description');
            }
            if (!Schema::hasColumn('dopes', 'airway_bill')) {
                $table->string('airway_bill')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dopes', function (Blueprint $table) {
            if (Schema::hasColumn('dopes', 'serial_number')) {
                $table->dropColumn('serial_number');
            }
            if (Schema::hasColumn('dopes', 'airway_bill')) {
                $table->dropColumn('airway_bill');
            }
        });
    }
};
