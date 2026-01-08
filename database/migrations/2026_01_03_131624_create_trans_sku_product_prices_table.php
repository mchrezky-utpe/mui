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
        Schema::create('trans_sku_product_prices', function (Blueprint $table) {
            $table->id();
            $table->string('manual_id', 50)->nullable();

            // prefix(code), description(name), 
            // bom(mst_sk_id)?(mungkin) (bom->number)
            $table->unsignedBigInteger('mst_sku_id');
            $table->foreign('mst_sku_id')->references('id')->on('mst_sku')->cascadeOnUpdate()->restrictOnDelete();
            // $table->string('priceable_type');

            // customor -> name
            $table->unsignedBigInteger('customer_id'); //fk
            $table->foreign('customer_id')->references('id')->on('mst_customer')->cascadeOnUpdate()->restrictOnDelete();

            $table->string('project_code'); // by customor & acceptable for manual
            $table->string('part_number');

            $table->unsignedBigInteger('general_currency_id');
            $table->foreign('general_currency_id')->references('id')->on('mst_general_currency')->cascadeOnUpdate()->restrictOnDelete();

            $table->decimal('price', 20, 4);
            $table->decimal('retail_price', 20, 4);

            $table->date('effective_from');
            $table->date('effective_to');

            $table->boolean('is_amortization')->default(false);
            $table->boolean('is_activated')->default(true);
            
            $table->boolean('flag_active')->default(true);

            addAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_sku_product_prices');
    }
};
