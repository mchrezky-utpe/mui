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
        Schema::table('mst_sku_process', function (Blueprint $table) {
            //
            $table->string('code')->nullable();
            $table->string('code_seq')->nullable();
            $table->string('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_sku_process', function (Blueprint $table) {
            //
            $table->dropColumn('code');
            $table->dropColumn('code_seq');
            $table->dropColumn('name');
        });
    }
};
