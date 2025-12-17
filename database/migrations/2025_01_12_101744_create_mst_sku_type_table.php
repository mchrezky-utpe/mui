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

            // fix PK supaya unsigned
            $table->unsignedBigInteger('id')->change();

            // kolom baru
            $table->string('code', 100)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('name', 100)->nullable();

            // foreign key
            $table->unsignedBigInteger('mst_sku_type_id');
            $table->foreign('mst_sku_type_id')
                ->references('id')
                ->on('mst_sku_type');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_sku_type');
    }
};
