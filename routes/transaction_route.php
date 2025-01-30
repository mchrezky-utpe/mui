<?php

use App\Http\Controllers\Transaction\Inventory\InventoryAdjustmentController;
use App\Http\Controllers\Transaction\Inventory\InventoryDoController;
use App\Http\Controllers\Transaction\Inventory\InventoryMaterialReqController;
use App\Http\Controllers\Transaction\Inventory\InventoryPurchaseReturnController;
use App\Http\Controllers\Transaction\Inventory\InventoryReceivingController;
use App\Http\Controllers\Transaction\Inventory\InventorySalesReturnController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transaction\PurchaseOrderController;
use App\Http\Controllers\Transaction\PurchaseOrderRequestController;
use App\Http\Controllers\Transaction\SkuPricelistController;
use App\Http\Controllers\Transaction\SkuMinOfStockController;
use App\Http\Controllers\Transaction\SkuMinOfQtyController;
use App\Http\Middleware\OnlyMemberMiddleware;

Route::controller(PurchaseOrderRequestController::class)->group(function () {
    Route::get("/pr", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/pr", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/pr/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/pr/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/pr/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::get("/pr/api/all", "api_all")->middleware(OnlyMemberMiddleware::class);
    // add po
    Route::post("/pr/po", "add_po")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(PurchaseOrderController::class)->group(function () {
    Route::get("/po", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/po", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/po/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/po/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/po/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::get("/po/api/all", "api_all")->middleware(OnlyMemberMiddleware::class);
    Route::get("/po/{id}/print", "print")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(SkuPricelistController::class)->group(function () {
    Route::get("/sku-pricelist", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-pricelist", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-pricelist/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-pricelist/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-pricelist/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-pricelist/api/by", "get_api_by")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(SkuMinOfStockController::class)->group(function () {
    Route::get("/sku-minofstock", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-minofstock", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-minofstock/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-minofstock/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-minofstock/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(SkuMinOfQtyController::class)->group(function () {
    Route::get("/sku-minofqty", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-minofqty", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-minofqty/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-minofqty/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-minofqty/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(InventoryReceivingController::class)->group(function () {
    Route::get("/inventory-receiving", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-receiving", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-receiving/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/inventory-receiving/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-receiving/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(InventoryDoController::class)->group(function () {
    Route::get("/inventory-do", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-do", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-do/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/inventory-do/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-do/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(InventoryMaterialReqController::class)->group(function () {
    Route::get("/inventory-material-req", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-material-req", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-material-req/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/inventory-material-req/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-material-req/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(InventorySalesReturnController::class)->group(function () {
    Route::get("/inventory-sales-return", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-sales-return", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-sales-return/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/inventory-sales-return/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-sales-return/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(InventoryPurchaseReturnController::class)->group(function () {
    Route::get("/inventory-purchase-return", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-purchase-return", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-purchase-return/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/inventory-purchase-return/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-purchase-return/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(InventoryAdjustmentController::class)->group(function () {
    Route::get("/inventory-adjustment", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-adjustment", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-adjustment/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/inventory-adjustment/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/inventory-adjustment/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});


