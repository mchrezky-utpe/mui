<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    // ADD
    Route::post("/person-supplier", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/person-supplier/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/person-supplier/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/person-supplier/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});
