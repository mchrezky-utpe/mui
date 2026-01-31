<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transaction\Sales\{
    SalesOrderController
};

Route::prefix('transaction/sales')->group(function () {
    Route::get('/', function () {
        return 'Halaman Sales';
    });

    Route::prefix('sales_order')->controller(SalesOrderController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/tambah', 'tambah');
        Route::get('/edit', 'edit');
        Route::get('/hapus', 'hapus');
    });
});
