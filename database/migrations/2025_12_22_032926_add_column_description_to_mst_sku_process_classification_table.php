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
            // $table->string('prefix')->nullable()->after('id');
            $table->string('description')->nullable()->after('prefix');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_sku_process_classification', function (Blueprint $table) {
            //
            // $table->dropColumn('prefix');
            $table->dropColumn('description');
        });
    }
};
