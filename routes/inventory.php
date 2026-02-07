<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transaction\Inventory\{
    StockOpeningController,
    StockAdjusmentController,
    MinimumStockController,
    ReceivingController,
    ProductionMaterialController,
    CustomerDeliveryScheduleController,
    CustomerReturnController,
    DeliveryOrderController,
    StockViewController,
    TransactionHistoryController,
    BalanceStockController,
    AgingStockController,
    MaterialAllowanceController,
    MaterialRequirementPlaningController
};

Route::prefix('transaction/inventory')->group(function () {
    Route::get('/', function () {
        return 'Halaman Inventory';
    });

    Route::prefix('stock_opening')->controller(StockOpeningController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/tambah', 'tambah');
        Route::get('/edit', 'edit');
        Route::get('/hapus', 'hapus');
        Route::post('/opening_stock', 'opening_stock');
    });

    Route::prefix('stock_adjusment')->controller(StockAdjusmentController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/tambah', 'tambah');
        Route::get('/edit', 'edit');
        Route::get('/hapus', 'hapus');
        Route::post('/adjusment_stock', 'adjusment_stock');
        Route::post('/import_adjusment_stock', 'import_adjusment_stock');
    });

    Route::prefix('minimum_stock')->controller(MinimumStockController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/tambah', 'tambah');
        Route::get('/edit', 'edit');
        Route::get('/hapus', 'hapus');
    });

    Route::prefix('receiving')->controller(ReceivingController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/tambah', 'tambah');
        Route::get('/edit', 'edit');
        Route::get('/hapus', 'hapus');
    });

    Route::prefix('production_material')->controller(ProductionMaterialController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/tambah', 'tambah');
        Route::get('/edit', 'edit');
        Route::get('/hapus', 'hapus');
    });

    Route::prefix('customer_delivery_schedule')->controller(CustomerDeliveryScheduleController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/tambah', 'tambah');
        Route::get('/edit', 'edit');
        Route::get('/hapus', 'hapus');
    });

    Route::prefix('customer_return')->controller(CustomerReturnController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/create', 'create');
        Route::get('/tambah', 'tambah');
        Route::get('/edit', 'edit');
        Route::get('/hapus', 'hapus');
        Route::get('/get-source', 'getSourceData');
        Route::get('/get-source-detail', 'getSourceDataDetail');
        Route::post('/create-cr', 'createCR');
        Route::get('/get-all', 'getAll');
        Route::get('/get-all-detail', 'getAllDetail');
    });

    Route::prefix('delivery_order')->controller(DeliveryOrderController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/create', 'create');
        Route::get('/edit', 'edit');
        Route::get('/hapus', 'hapus');
        Route::get('/get-all', 'getAll');
        Route::get('/get-all-detail', 'getAllDetail');
        Route::get('/get-destination', 'getDestination');
        Route::get('/get-delivery-source', 'getDeliverySource');
        Route::get('/item-detail', 'getItemDetail');
        Route::post('/create-do', 'createDO');
        Route::get('/export-pdf', 'exportPDF');
    });

    Route::prefix('stock_view')->controller(StockViewController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/all', 'getAll');
    });

    Route::prefix('transaction_history')->controller(TransactionHistoryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
    });

    Route::prefix('balance_stock')->controller(BalanceStockController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
    });

    Route::prefix('aging_stock')->controller(AgingStockController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
    });

    Route::prefix('material_allowance')->controller(MaterialAllowanceController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/tambah', 'tambah');
        Route::get('/edit', 'edit');
        Route::get('/hapus', 'hapus');
    });

    Route::prefix('material_requirement_planing')->controller(MaterialRequirementPlaningController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/data', 'data');
        Route::get('/tambah', 'tambah');
        Route::get('/edit', 'edit');
        Route::get('/hapus', 'hapus');
    });
});
