<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asset_types', function (Blueprint $table) {
            $table->dropColumn(['useful_life_years', 'depreciation_method']);
        });
    }

    public function down(): void
    {
        Schema::table('asset_types', function (Blueprint $table) {
            $table->integer('useful_life_years')->default(5);
            $table->string('depreciation_method')->default('straight_line');
        });
    }
};
