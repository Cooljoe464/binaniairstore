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
        Schema::table('requisitions', function (Blueprint $table) {
            $table->dropForeign(['aircraft_id']);
            $table->dropColumn('aircraft_id');
            $table->string('aircraft_registration')->nullable()->after('part_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->dropColumn('aircraft_registration');
            $table->foreignUuid('aircraft_id')->nullable()->constrained('aircraft');
        });
    }
};
