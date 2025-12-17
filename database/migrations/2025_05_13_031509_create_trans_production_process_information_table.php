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
        if (Schema::hasTable("trans_production_process_information")) {
            return;
        }
        
        Schema::create('trans_production_process_information', function (Blueprint $table) {
            $table->id();
            $table->string('description', 100)->nullable()->comment('Description');
            $table->tinyInteger('flag_process_classification')->nullable()->comment('1. regular 2. satin');
            $table->tinyInteger('flag_checking_input_method')->nullable()->comment('1. normal 2. hourly');
            $table->tinyInteger('flag_item_size_category')->nullable()->comment('1. small 2. big');
            $table->string('line_part_code', 100)->nullable()->comment('Line Part Code');
            $table->decimal('val_area', 20, 4)->default(0.0000)->comment('Area Value');
            $table->decimal('val_weight', 20, 4)->default(0.0000)->comment('Weight Value');
            $table->decimal('qty_standard', 20, 4)->default(0.0000)->comment('Standard Quantity');
            $table->decimal('qty_target', 20, 4)->default(0.0000)->comment('Target Quantity');
            $table->tinyInteger('flag_active')->nullable()->comment('Active Flag');
            $table->tinyInteger('flag_status')->default(1)->comment('Status Flag');
            $table->string('manual_id', 50)->nullable();
            $table->string('generated_id', 64)->nullable();
            $table->bigInteger('sku_id')->nullable();
            $table->bigInteger('bom_detail_id')->nullable();
            
            addAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_production_process_information');
    }
};
