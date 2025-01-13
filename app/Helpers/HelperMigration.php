<?php

use Illuminate\Database\Schema\Blueprint;

if (!function_exists('addAuditColumns')) {
    /**
     * Add audit columns to a table.
     *
     * @param  \Illuminate\Database\Schema\Blueprint  $table
     * @return void
     */
    function addAuditColumns(Blueprint $table)
    {
        $table->string('created_by',50)->nullable();
        $table->timestamp('created_at')->nullable();
        $table->string('updated_by',50)->nullable();
        $table->timestamp('updated_at')->nullable();
        $table->string('deleted_by',50)->nullable();
        $table->timestamp('deleted_at')->nullable();
    }
}
