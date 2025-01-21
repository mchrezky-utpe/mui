<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transaction\PurchaseOrderController;
use App\Http\Controllers\Transaction\SkuPricelistController;
use App\Http\Controllers\Transaction\SkuMinOfStockController;
use App\Http\Controllers\Transaction\SkuMinOfQtyController;
use App\Http\Middleware\OnlyMemberMiddleware;

Route::controller(PurchaseOrderController::class)->group(function () {
    Route::get("/po", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/po", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/po/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/po/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/po/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(SkuPricelistController::class)->group(function () {
    Route::get("/sku-pricelist", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-pricelist", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-pricelist/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-pricelist/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-pricelist/edit", "edit")->middleware(OnlyMemberMiddleware::class);
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


