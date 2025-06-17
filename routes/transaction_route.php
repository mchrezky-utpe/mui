<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\OnlyMemberMiddleware;
use App\Http\Controllers\Transaction\Inventory\InventoryAdjustmentController;
use App\Http\Controllers\Transaction\Inventory\InventoryDoController;
use App\Http\Controllers\Transaction\Inventory\InventoryMaterialReqController;
use App\Http\Controllers\Transaction\Inventory\InventoryPurchaseReturnController;
use App\Http\Controllers\Transaction\Inventory\InventoryReceivingController;
use App\Http\Controllers\Transaction\Inventory\InventorySalesReturnController;
use App\Http\Controllers\Transaction\PurchaseOrderController;
use App\Http\Controllers\Transaction\PurchaseOrderRequestController;
use App\Http\Controllers\Transaction\SkuPricelistController;
use App\Http\Controllers\Transaction\SkuMinOfStockController;
use App\Http\Controllers\Transaction\SkuMinOfQtyController;
use App\Http\Controllers\Transaction\Approval\ApprovalPurchaseRequestController;
use App\Http\Controllers\Transaction\SdsController;
use App\Http\Controllers\Transaction\SdoController;
use App\Http\Controllers\Transaction\Receiving\GpoController;
use App\Http\Controllers\Transaction\Receiving\SupplyController;
use App\Http\Controllers\Transaction\Receiving\ReplacementController;
use App\Http\Controllers\Transaction\Receiving\InternalController;
use App\Http\Controllers\Transaction\Receiving\ReturnablePackagingController;
use App\Http\Controllers\Transaction\Bom\BomController;
use App\Http\Controllers\Transaction\StockViewController;


Route::controller(ApprovalPurchaseRequestController::class)->group(function () {
    Route::get("/approval-pr", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/approval-pr/approve", "apporve")->middleware(OnlyMemberMiddleware::class);
    Route::post("/approval-pr/deny", "deny")->middleware(OnlyMemberMiddleware::class);
    Route::post("/approval-pr/hold", "hold")->middleware(OnlyMemberMiddleware::class);
    Route::get("/approval-pr/item/{id}", "getItem")->middleware(OnlyMemberMiddleware::class);
    Route::post("/approval-pr/item/deny", "deny_item")->middleware(OnlyMemberMiddleware::class);
    Route::post("/approval-pr/item/hold", "hold_item")->middleware(OnlyMemberMiddleware::class);
});


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
    Route::get("/api/po/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/po/item", "api_item_by")->middleware(OnlyMemberMiddleware::class);
    Route::post("/po/upload", "upload")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(SkuPricelistController::class)->group(function () {
    Route::get("/sku-pricelist", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-pricelist", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-pricelist/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-pricelist/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-pricelist/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-pricelist/api/by", "get_api_by")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-pricelist/api/history", "getHistory")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-pricelist/api/all/pagination", "getAllPagination")->middleware(OnlyMemberMiddleware::class);
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

Route::controller(SdsController::class)->group(function () {
    Route::get("/sds", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sds", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sds/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sd/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sds/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sds/send-to-edi", "send_to_edi")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sds/reschedule", "reschedule")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sds/pull-back", "pull_back")->middleware(OnlyMemberMiddleware::class);
});

// RECEIVING
Route::controller(SdoController::class)->group(function () {
    Route::get("/sdo", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sdo", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sdo/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sdo/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sdo/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/sdo/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/sdo/item", "api_item_by")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sdo/receive", "receive")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/sdo/detail", "detail")->middleware(OnlyMemberMiddleware::class);
});
Route::controller(GpoController::class)->group(function () {
    Route::get("/gpo", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/gpo", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/gpo/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/gpo/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/gpo/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/gpo/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
});
Route::controller(SupplyController::class)->group(function () {
    Route::get("/supply", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/supply", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/supply/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/supply/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/supply/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/supply/item", "api_item")->middleware(OnlyMemberMiddleware::class);
});
Route::controller(ReplacementController::class)->group(function () {
    Route::get("/replacement", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/replacement", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/replacement/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/replacement/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/replacement/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/replacement/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/replacement/item", "api_item_by")->middleware(OnlyMemberMiddleware::class);
    Route::post("/replacement/receive", "receive")->middleware(OnlyMemberMiddleware::class);
});
Route::controller(InternalController::class)->group(function () {
    Route::get("/internal", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/internal", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/internal/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/internal/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/internal/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/internal/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/internal/item", "api_item_by")->middleware(OnlyMemberMiddleware::class);
    Route::post("/internal/receive", "receive")->middleware(OnlyMemberMiddleware::class);
});
Route::controller(ReturnablePackagingController::class)->group(function () {
    Route::get("/returnable-packaging", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/returnable-packaging", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/returnable-packaging/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/returnable-packaging/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/returnable-packaging/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/returnable-packaging/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/returnable-packaging/item", "api_item_by")->middleware(OnlyMemberMiddleware::class);
    Route::post("/returnable-packaging/receive", "receive")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(StockViewController::class)->group(function () {
    Route::get("/stock-view", "index")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/stock-view", "api_all")->middleware(OnlyMemberMiddleware::class);
    Route::post("/api/stock-view/sync", "sync")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(BomController::class)->group(function () {
    Route::get("/bom", "index")->middleware(OnlyMemberMiddleware::class);
    Route::get("/bom/all/pageable", "get_list_pageable")->middleware(OnlyMemberMiddleware::class);
    Route::post("/bom", "add")->middleware(OnlyMemberMiddleware::class);
    Route::get("/bom/{id}/edit-detail", "edit_detail")->middleware(OnlyMemberMiddleware::class);
    Route::post("/bom/edit-detail", "do_edit_detail")->middleware(OnlyMemberMiddleware::class);
    Route::post("/bom/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
});


