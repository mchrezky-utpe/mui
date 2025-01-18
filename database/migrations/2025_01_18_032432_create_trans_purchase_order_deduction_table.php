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
        Schema::create('trans_purchase_order_deduction', function (Blueprint $table) {
            $table->id();
            $table->date('trans_date')->nullable();
            $table->string('description', 100)->nullable();
            $table->decimal('value_d', 20, 4)->nullable();
            $table->decimal('value_f', 20, 4)->nullable();
            $table->decimal('qty', 20, 4)->nullable();
            $table->decimal('total_d', 20, 4)->nullable();
            $table->decimal('total_f', 20, 4)->nullable();
            $table->integer('counter')->nullable();
            $table->integer('flag_active')->nullable();
            $table->string('manual_id', 50)->nullable();
            $table->string('generated_id', 64)->nullable();
            $table->integer('trans_po_id')->nullable();
            $table->integer('gen_deductor_id')->nullable();
            addAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_purchase_order_deduction');
    }
};
