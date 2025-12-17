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
        Schema::table('mst_sku_business_type', function (Blueprint $table) {
            //
            $table->string("name")->nullable();
            $table->string("code")->nullable();
            $table->enum("category", ["AUTOMOTIVE", "NON-AUTOMOTIVE"])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_sku_business_type', function (Blueprint $table) {
            //
            $table->dropColumn('name');
            $table->dropColumn('code');
            $table->dropColumn('category');
        });
    }
};
