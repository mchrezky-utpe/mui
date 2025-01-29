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
        Schema::create('inventory_purchase_return', function (Blueprint $table) {
            $table->id();
            $table->string('description', 100)->nullable();
            $table->string('prefix', 50)->nullable();
            $table->boolean('flag_active')->nullable();
            $table->string('manual_id', 50)->nullable();
            $table->string('generated_id', 64)->nullable();
            addAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_purchase_return');
    }
};
