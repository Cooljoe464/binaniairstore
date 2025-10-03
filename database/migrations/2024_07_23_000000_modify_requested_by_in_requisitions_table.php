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
            $table->foreignId('requested_by_id')->nullable()->after('issued_by_id')->constrained('users');
            $table->dropColumn('requested_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->string('requested_by')->nullable();
            $table->dropForeign(['requested_by_id']);
            $table->dropColumn('requested_by_id');
        });
    }
};
