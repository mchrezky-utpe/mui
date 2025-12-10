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
        Schema::table('mst_sku_process_type', function (Blueprint $table) {
            //
            $table->string('code', 100)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('name', 100)->nullable();
            // $table->integer('item_type_id')->nullable();

            $table->unsignedBigInteger('mst_sku_type_id');
            $table->foreign('mst_sku_type_id')->references('id')->on('mst_sku_type');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_sku_process_type', function (Blueprint $table) {
            //
            $table->dropColumn(['code', 'category', 'name', 'mst_sku_type']);
        });
    }
};
