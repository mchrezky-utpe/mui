<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $table = 'mst_sku_process_type';

    public function up(): void
    {
        if (Schema::hasTable($this->table)) {
            return;
        }

        Schema::create($this->table, function (Blueprint $table) {

            $table->id(); // unsignedBigInteger primary key

            $table->string('description', 100)->nullable();
            $table->string('prefix', 100)->nullable();
            $table->boolean('flag_active')->nullable();
            $table->string('manual_id', 50)->nullable();
            $table->string('generated_id', 64)->nullable();

            $table->string('code', 100)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->unsignedBigInteger("mst_sku_type_id");
            // $table->foreignId('mst_sku_type_id')->constrained('mst_sku_type'); // membuat FK otomatis

            addAuditColumns($table);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
