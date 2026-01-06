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
        Schema::table('assets', function (Blueprint $wrapper) {
            $wrapper->string('assigned_by')->nullable()->after('handed_over_by');
            $wrapper->date('assigned_date')->nullable()->after('assigned_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $wrapper) {
            $wrapper->dropColumn(['assigned_by', 'assigned_date']);
        });
    }
};
