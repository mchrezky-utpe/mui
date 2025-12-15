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
        Schema::table('mst_sku_process_classification', function (Blueprint $table) {
            //
            $table->bigInteger('mst_sku_process_type_id');
            $table->foreign('mst_sku_process_type_id')
                ->references('id')
                ->on('mst_sku_process_type')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_sku_process_classification', function (Blueprint $table) {
            //
            $table->dropForeign(['mst_sku_process_type_id']);
            $table->dropColumn("mst_sku_process_type_id");
        });
    }
};
