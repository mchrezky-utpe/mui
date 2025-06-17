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
        Schema::create('trans_prod_cost', function (Blueprint $table) {
           $table->id();
            $table->string('sku_name', 100)->nullable()->comment('SKU Name');
            $table->string('sku_model', 100)->nullable()->comment('SKU Model');
            $table->tinyInteger('flag_status')->nullable()->default(1)->comment('0: inactive, 1: active');
            $table->tinyInteger('flag_active')->nullable()->comment('Active Flag');

            $table->string('manual_id', 50)->nullable();
            $table->string('generated_id', 64)->nullable();

            $table->unsignedBigInteger('sku_id')->nullable();
            $table->unsignedBigInteger('bom_id')->nullable();

            addAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_prod_cost');
    }
};
