<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\OnlyMemberMiddleware;
use App\Http\Controllers\Master\Sku\MasterSkuCategoryController;
use App\Http\Controllers\Master\Sku\MasterSkuSubCategoryController;
use App\Http\Controllers\Master\Sku\MasterSkuClassificationController;
use App\Http\Controllers\Master\Sku\MasterSkuSalesController;
use App\Http\Controllers\Master\MasterSkuTypeController;
use App\Http\Controllers\Master\MasterSkuUnitController;
use App\Http\Controllers\Master\MasterSkuModelController;
use App\Http\Controllers\Master\MasterSkuBusinessController;
use App\Http\Controllers\Master\MasterPackagingInformationCategoryController;
use App\Http\Controllers\Master\MasterPackagingInformationPartitionController;


Route::controller(MasterSkuCategoryController::class)->group(function () {
    Route::get("/api/sku-category/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterSkuSubCategoryController::class)->group(function () {
    Route::get("/api/sku-sub-category/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterSkuClassificationController::class)->group(function () {
    Route::get("/api/sku-classification/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterSkuSalesController::class)->group(function () {
    Route::get("/api/sku-sales/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
});


Route::controller(MasterSkuTypeController::class)->group(function () {
    // LIST
    Route::get("/sku-type", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/sku-type", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/sku-type/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/sku-type/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT
    Route::post("/sku-type/edit", "edit")->middleware(OnlyMemberMiddleware::class);

    Route::get("/api/sku-type/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);

    Route::get("/api/sku-type/droplist/general-item", "api_droplist_for_general_item")->middleware(OnlyMemberMiddleware::class);

    Route::get("/api/sku-type/group-tag", "api_group_tag")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/sku-type/name-n-extension", "api_name_n_extension")->middleware(OnlyMemberMiddleware::class);

    // API
    Route::get("/api/sku-type", "api_all")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/sku-type/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/api/sku-type", "api_add")->middleware(OnlyMemberMiddleware::class);
    Route::put("/api/sku-type/{id}", "api_edit")->middleware(OnlyMemberMiddleware::class);
    Route::delete("/api/sku-type/{id}", "api_delete")->middleware(OnlyMemberMiddleware::class);
    // name n ext
});

Route::controller(MasterSkuUnitController::class)->group(function () {
    // LIST
    Route::get("/sku-unit", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/sku-unit", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/sku-unit/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/sku-unit/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT
    Route::post("/sku-unit/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-unit/{id}", "get")->middleware(OnlyMemberMiddleware::class);

    Route::get("/api/sku-unit/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);

    // API
    Route::get("/api/sku-unit", "api_all")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/sku-unit/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/api/sku-unit", "api_add")->middleware(OnlyMemberMiddleware::class);
    Route::put("/api/sku-unit/{id}", "api_edit")->middleware(OnlyMemberMiddleware::class);
    Route::delete("/api/sku-unit/{id}", "api_delete")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterSkuModelController::class)->group(function () {
    // LIST
    Route::get("/sku-model", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/sku-model", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/sku-model/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/sku-model/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT
    Route::post("/sku-model/edit", "edit")->middleware(OnlyMemberMiddleware::class);

    Route::get("/api/sku-model/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterSkuBusinessController::class)->group(function () {
    // LIST
    Route::get("/sku-business", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/sku-business", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/sku-business/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/sku-business/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT
    Route::post("/sku-business/edit", "edit")->middleware(OnlyMemberMiddleware::class);

    Route::get("/api/sku-business/droplist", "api_droplist")->middleware(OnlyMemberMiddleware::class);
});



Route::controller(MasterPackagingInformationCategoryController::class)->group(function () {
    // INFORMATION
    Route::get("/packaging-information-category", "index")->middleware(OnlyMemberMiddleware::class);

    Route::get("/packaging-information-category/all", "get_all")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/packaging-information-category", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/packaging-information-category/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/packaging-information-category/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT
    Route::post("/packaging-information-category/edit", "edit")->middleware(OnlyMemberMiddleware::class);

});


Route::controller(MasterPackagingInformationPartitionController::class)->group(function () {
    // PARTITION
    Route::get("/packaging-information-partition", "index")->middleware(OnlyMemberMiddleware::class);

    Route::get("/packaging-information-partition/all", "get_all")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/packaging-information-partition", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/packaging-information-partition/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/packaging-information-partition/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT
    Route::post("/packaging-information-partition/edit", "edit")->middleware(OnlyMemberMiddleware::class);

});
