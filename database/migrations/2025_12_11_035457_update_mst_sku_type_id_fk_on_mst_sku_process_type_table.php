<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mst_sku_process_type', function (Blueprint $table) {

            // Ubah kolom jadi BIGINT SIGNED
            $table->bigInteger('mst_sku_type_id')->change(); // signed!
        });

        // Tambahkan FK setelah tipe sama
        Schema::table('mst_sku_process_type', function (Blueprint $table) {
            $table->foreign('mst_sku_type_id')
                ->references('id')
                ->on('mst_sku_type')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('mst_sku_process_type', function (Blueprint $table) {
            $table->dropForeign(['mst_sku_type_id']);

            // Balikin ke unsigned (optional)
            $table->unsignedBigInteger('mst_sku_type_id')->change();
        });
    }
};
