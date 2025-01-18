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
        Schema::create('trans_purchase_order', function (Blueprint $table) {
            $table->id();
            $table->date('trans_date')->nullable();
            $table->string('description', 100)->nullable();
            $table->string('doc_num', 50)->nullable();
            $table->integer('doc_counter')->nullable();
            $table->integer('flag_status')->nullable();
            $table->date('valid_from_date')->nullable();
            $table->date('valid_to_date')->nullable();
            $table->integer('revision')->nullable();
            $table->integer('flag_type')->nullable();
            $table->boolean('flag_active')->nullable();
            $table->string('manual_id', 50)->nullable();
            $table->string('generated_id', 64)->nullable();
            $table->integer('gen_terms_detail_id')->nullable();
            $table->integer('gen_currency_id')->nullable();
            $table->integer('gen_department_id')->nullable();
            $table->integer('prs_supplier_id')->nullable();
            addAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_purchase_order');
    }
};
