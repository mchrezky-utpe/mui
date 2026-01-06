<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    protected $table_name = "mst_general_currency";

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->table_name)) return;

        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('description', 100)->nullable();
            $table->string('prefix', 50)->nullable();
            $table->boolean('flag_active')->nullable();
            $table->boolean('flag_show')->nullable();
            addAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
