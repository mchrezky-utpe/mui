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
       Schema::create('trans_production_cycle_time', function (Blueprint $table) {
        $table->id();
        $table->string('description', 100)->nullable()->comment('Item Name');
        $table->decimal('num_jigging', 20, 4)->default(0.0000)->comment('Jigging');
        $table->decimal('num_lineprocess', 20, 4)->default(0.0000)->comment('Line Process');
        $table->decimal('num_unjigging', 20, 4)->default(0.0000)->comment('Unjigging');
        $table->decimal('num_inspection', 20, 4)->default(0.0000)->comment('Inspection');
        $table->decimal('num_assembly', 20, 4)->default(0.0000)->comment('Assembly');
        $table->decimal('num_cutting', 20, 4)->default(0.0000)->comment('Cutting');
        $table->decimal('num_masking', 20, 4)->default(0.0000)->comment('Masking');
        $table->decimal('num_buffing', 20, 4)->default(0.0000)->comment('Buffing');
        $table->boolean('flag_active')->nullable();        
        addAuditColumns($table);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_production_cycle_time');
    }
};