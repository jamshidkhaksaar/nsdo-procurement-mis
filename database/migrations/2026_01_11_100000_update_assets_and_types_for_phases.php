<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('serial_number')->nullable()->after('asset_tag');
            $table->decimal('useful_life_years', 8, 2)->nullable()->after('quantity');
            $table->date('purchase_date')->nullable()->after('useful_life_years');
        });

        Schema::table('asset_types', function (Blueprint $table) {
            $table->string('category')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['serial_number', 'useful_life_years', 'purchase_date']);
        });

        Schema::table('asset_types', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
