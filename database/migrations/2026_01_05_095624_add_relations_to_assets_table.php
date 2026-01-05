<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'asset_type_id')) {
                $table->foreignId('asset_type_id')->nullable()->constrained()->nullOnDelete()->after('name');
            }
            if (!Schema::hasColumn('assets', 'province_id')) {
                $table->foreignId('province_id')->nullable()->constrained()->nullOnDelete()->after('condition');
            }
            if (!Schema::hasColumn('assets', 'department_id')) {
                $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete()->after('province_id');
            }
            if (!Schema::hasColumn('assets', 'staff_id')) {
                $table->foreignId('staff_id')->nullable()->constrained('staff')->nullOnDelete()->after('department_id');
            }
            if (!Schema::hasColumn('assets', 'room_number')) {
                // 'location' column didn't exist, so we place it after 'location_department'
                $table->string('room_number')->nullable()->after('location_department'); 
            }
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // We can safely attempt to drop them
            $table->dropForeign(['asset_type_id']);
            $table->dropForeign(['province_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['staff_id']);
            $table->dropColumn(['asset_type_id', 'province_id', 'department_id', 'staff_id', 'room_number']);
        });
    }
};
