<?php

use App\Http\Controllers\Transaction\Sales\SalesInvoiceController;
use App\Http\Controllers\Transaction\Sales\SalesOrderController;
use App\Http\Middleware\OnlyMemberMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('transaction/sales')->middleware(OnlyMemberMiddleware::class)->group(function () {
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

    Route::prefix('sales_invoice')->controller(SalesInvoiceController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/all', 'getAll');
        Route::get('/all-detail', 'getAllDetail');
        Route::get('/source', 'getSourceData');
        Route::get('/source/detail', 'getSourceDetail');
        Route::get('/exchange-rate', 'getExchangeRate');
        Route::post('/create-invoice', 'createInvoice');
    });
});
