<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Expand Enum to include 'Scrap' so we can migrate data
        DB::statement("ALTER TABLE assets MODIFY COLUMN `condition` ENUM('New', 'Good', 'Fair', 'Poor', 'Broken', 'Scrap') DEFAULT 'New'");

        // 2. Update existing 'Broken' records to 'Scrap'
        DB::table('assets')->where('condition', 'Broken')->update(['condition' => 'Scrap']);

        // 3. Schema changes: Remove photo, add new fields
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('photo_path');

            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->date('delivery_date')->nullable();
            $table->date('gr_date')->nullable(); // Goods Received Date
            $table->decimal('unit_price', 12, 2)->nullable();
            $table->string('currency', 10)->default('AFN'); // AFN, USD, EURO
            $table->decimal('total_amount', 12, 2)->nullable();
        });

        // 4. Finalize Enum: Remove 'Broken'
        DB::statement("ALTER TABLE assets MODIFY COLUMN `condition` ENUM('New', 'Good', 'Fair', 'Poor', 'Scrap') DEFAULT 'New'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Revert Enum
            $table->enum('condition', ['New', 'Good', 'Fair', 'Poor', 'Broken'])->default('New')->change();
            
            // Revert Photo
            $table->string('photo_path')->nullable();
            
            // Drop New Fields
            $table->dropForeign(['supplier_id']);
            $table->dropColumn(['supplier_id', 'delivery_date', 'gr_date', 'unit_price', 'currency', 'total_amount']);
        });
        
        // Revert data 'Scrap' -> 'Broken'
        DB::table('assets')->where('condition', 'Scrap')->update(['condition' => 'Broken']);
    }
};
