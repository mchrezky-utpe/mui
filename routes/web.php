<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Master\MasterGeneralCurrencyController;
use App\Http\Controllers\Master\MasterGeneralDeductorController;
use App\Http\Controllers\Master\MasterGeneralDepartmentController;
use App\Http\Controllers\Master\MasterGeneralExchageRatesController;
use App\Http\Controllers\Master\MasterGeneralExchangeRatesController;
use App\Http\Controllers\Master\MasterGeneralOtherCostController;
use App\Http\Controllers\Master\MasterGeneralTaxController;
use App\Http\Controllers\Master\MasterGeneralTermsController;
use App\Http\Controllers\Master\MasterPersonCustomerController;
use App\Http\Controllers\Master\MasterPersonSupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Master\MasterSkuController;
use App\Http\Controllers\Master\MasterSkuTypeController;
use App\Http\Controllers\Master\MasterSkuUnitController;
use App\Http\Controllers\Master\MasterSkuModelController;
use App\Http\Controllers\Master\MasterSkuProcessController;
use App\Http\Controllers\Master\MasterSkuPackagingController;
use App\Http\Controllers\Master\MasterSkuDetailController;
use App\Http\Controllers\Master\MasterSkuBusinessController;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;

require_once base_path('routes/transaction_route.php');

Route::get('/', function () {
    return view('dashboard.dashboard');
});

Route::controller(AuthController::class)->group(function () {
    Route::get("/login", "login")->middleware(OnlyGuestMiddleware::class);
    Route::post("/login", "doLogin")->middleware(OnlyGuestMiddleware::class);
    Route::post("/logout", "doLogout")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(UserController::class)->group(function () {
    // LIST
    Route::get("/user", "index");
    // ADD
    Route::post("/user", "add");
    // DELETE
    Route::post("/user/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/user/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/user/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterSkuController::class)->group(function () {
    // LIST
    Route::get("/sku", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/sku", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/sku/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/sku/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/sku/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    // API ALL
    Route::get("/api/sku", "api_all")->middleware(OnlyMemberMiddleware::class);
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
    // API GET ALL DATA
    Route::get("/api/sku-unit", "api_all")->middleware(OnlyMemberMiddleware::class);
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
});

Route::controller(MasterSkuProcessController::class)->group(function () {
    // LIST
    Route::get("/sku-process", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/sku-process", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/sku-process/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/sku-process/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/sku-process/edit", "edit")->middleware(OnlyMemberMiddleware::class);
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
});

Route::controller(MasterSkuPackagingController::class)->group(function () {
    // LIST
    Route::get("/sku-packaging", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/sku-packaging", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/sku-packaging/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/sku-packaging/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/sku-packaging/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterSkuDetailController::class)->group(function () {
    // LIST
    Route::get("/sku-detail", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/sku-detail", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/sku-detail/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/sku-detail/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/sku-detail/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterPersonSupplierController::class)->group(function () {
    // LIST
    Route::get("/person-supplier", "index")->middleware(OnlyMemberMiddleware::class);
    Route::get("/person-supplier/index2", "index2")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/person-supplier", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/person-supplier/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/person-supplier/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    Route::post("/person-supplier/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/person-supplier/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/person-supplier/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    // API GET ALL DATA
    Route::get("/api/person-supplier", "api_all")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterPersonCustomerController::class)->group(function () {
    // LIST
    Route::get("/person-customer", "index")->middleware(OnlyMemberMiddleware::class);
    Route::get("/person-customer/index2", "index2")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/person-customer", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/person-customer/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/person-customer/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    Route::post("/person-customer/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/person-customer/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/person-customer/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterGeneralTermsController::class)->group(function () {
    // LIST
    Route::get("/general-terms", "index")->middleware(OnlyMemberMiddleware::class);
    Route::get("/general-terms/index2", "index2")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/general-terms", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/general-terms/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/general-terms/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    Route::post("/general-terms/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/general-terms/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/general-terms/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterGeneralDepartmentController::class)->group(function () {
    // LIST
    Route::get("/general-department", "index")->middleware(OnlyMemberMiddleware::class);
    //LIST DELETED
    Route::get("/general-department/index2", "index2")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/general-department", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/general-department/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/general-department/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/general-department/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    // HAPUS PERMANEN
    Route::post("/general-department/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    //RESTORE
    Route::post("/general-department/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterGeneralCurrencyController::class)->group(function () {
    // LIST
    Route::get("/general-currency", "index")->middleware(OnlyMemberMiddleware::class);
    //LIST DELETED
    Route::get("/general-currency/deleted", "index2")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/general-currency", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/general-currency/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // HAPUS PERMANEN
    Route::post("/general-currency/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    //RESTORE
    Route::post("/general-currency/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/general-currency/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/general-currency/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterGeneralTaxController::class)->group(function () {
    // LIST
    Route::get("/general-tax", "index")->middleware(OnlyMemberMiddleware::class);
    Route::get("/general-tax/index2", "index2")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/general-tax", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/general-tax/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/general-tax/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    Route::post("/general-tax/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/general-tax/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/general-tax/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterGeneralDeductorController::class)->group(function () {
    // LIST
    Route::get("/general-deductor", "index")->middleware(OnlyMemberMiddleware::class);
    //LIST DELETED
    Route::get("/general-deductor/index2", "index2")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/general-deductor", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/general-deductor/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/general-deductor/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/general-deductor/edit", "edit")->middleware(OnlyMemberMiddleware::class);

    
    // HAPUS PERMANEN
    Route::post("/general-deductor/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    //RESTORE
    Route::post("/general-deductor/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterGeneralOtherCostController::class)->group(function () {
    // LIST
    Route::get("/general-other-cost", "index")->middleware(OnlyMemberMiddleware::class);
    Route::get("/general-other-cost/index2", "index2")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/general-other-cost", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/general-other-cost/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/general-other-cost/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    Route::post("/general-other-cost/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/general-other-cost/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/general-other-cost/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterGeneralExchageRatesController::class)->group(function () {
    // LIST
    Route::get("/general-exchange-rates", "index")->middleware(OnlyMemberMiddleware::class);
    Route::get("/general-exchange-rates/index2", "index2")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/general-exchange-rates", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/general-exchange-rates/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/general-exchange-rates/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    Route::post("/general-exchange-rates/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/general-exchange-rates/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/general-exchange-rates/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});
