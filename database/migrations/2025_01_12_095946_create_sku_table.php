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
        Schema::create('mst_sku', function (Blueprint $table) {
            $table->id();
            $table->string('description', 50)->nullable();
            $table->string('prefix', 50)->nullable();
            $table->boolean('flag_active')->nullable();
            $table->boolean('flag_show')->nullable();; 
            $table->string('manual_id', 50)->nullable();;
            $table->string('generated_id', 64)->nullable();;
            $table->integer('sku_type_id')->nullable();;
            $table->integer('sku_unit_id')->nullable();;
            $table->integer('sku_model_id')->nullable();;
            $table->integer('sku_process_id')->nullable();;
            $table->integer('sku_business_type_id')->nullable();;
            $table->integer('sku_packaging_id')->nullable();;
            $table->integer('sku_detail_id')->nullable();;
            addAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_sku');
    }
};
