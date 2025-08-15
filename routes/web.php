<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Master\MasterFactoryMachineController;
use App\Http\Controllers\Master\MasterFactoryWarehouseController;
use App\Http\Controllers\Master\MasterGeneralCurrencyController;
use App\Http\Controllers\Master\MasterGeneralDeductorController;
use App\Http\Controllers\Master\MasterGeneralDepartmentController;
use App\Http\Controllers\Master\MasterGeneralExchageRatesController;
use App\Http\Controllers\Master\MasterGeneralOtherCostController;
use App\Http\Controllers\Master\MasterGeneralTaxController;
use App\Http\Controllers\Master\MasterGeneralTermsController;
use App\Http\Controllers\Master\MasterPersonCustomerController;
use App\Http\Controllers\Master\MasterPersonEmployeeController;
use App\Http\Controllers\Master\MasterPersonSupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Master\MasterSkuController;
use App\Http\Controllers\Master\MasterSkuProcessController;
use App\Http\Controllers\Master\MasterSkuPackagingController;
use App\Http\Controllers\Master\MasterSkuDetailController;
use App\Http\Controllers\Transaction\Production\ProductionController;
use App\Http\Controllers\Transaction\Production\ProductionCostController;
use App\Http\Controllers\Transaction\Production\ProductionProcessController;
use App\Http\Controllers\Transaction\PurchaseOrderController;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;

require_once base_path('routes/transaction_route.php');
require_once base_path('routes/master_route.php');

Route::get('/', function () {
    return view('dashboard.dashboard');
})->middleware(OnlyMemberMiddleware::class);


Route::controller(AuthController::class)->group(function () {
    Route::get("/login", "login")->middleware(OnlyGuestMiddleware::class);
    Route::post("/login", "doLogin")->middleware(OnlyGuestMiddleware::class);
    Route::post("/logout", "doLogout")->middleware(OnlyMemberMiddleware::class);
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
    Route::get("/sku-part-information", "index")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-production-material", "index_production_material")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-general-item", "index_general_item")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/sku", "api_all_sku")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/sku-part-information", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-production-material", "add_production_material")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-general-item", "add_general_item")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/sku-part-information/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-production-material/{id}/delete", "delete_production_material")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-general-item/{id}/delete", "delete_general_item")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/sku-part-information/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-production-material/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::get("/sku-general-item/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/sku-part-information/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-production-material/edit", "edit_production_material")->middleware(OnlyMemberMiddleware::class);
    Route::post("/sku-general-item/edit", "edit_general_item")->middleware(OnlyMemberMiddleware::class);
    // API ALL
    Route::get("/api/sku-part-information", "api_sku_part_information")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/sku-production-material", "api_production_material_all")->middleware(OnlyMemberMiddleware::class);
    Route::get("/api/sku-general-item", "api_general_information_all")->middleware(OnlyMemberMiddleware::class);
    // Route::get("/api/sku-general-item", "api_all")->middleware(OnlyMemberMiddleware::class);

    Route::get("/api/sku-part-information/get-set-code", "get_set_code")->middleware(OnlyMemberMiddleware::class);
    // Route::get("/api/sku-production-material/get-set-code", "get_set_code")->middleware(OnlyMemberMiddleware::class);
    // Route::get("/api/sku-general-item/get-set-code", "get_set_code")->middleware(OnlyMemberMiddleware::class);
    
    Route::get("/api/sku-part-information/get-code", "get_code")->middleware(OnlyMemberMiddleware::class);
    // Route::get("/api/sku-production-material/get-code", "get_code")->middleware(OnlyMemberMiddleware::class);
    // Route::get("/api/sku-general-item/get-code", "get_code")->middleware(OnlyMemberMiddleware::class);

    // Route::get('/sku/export', 'export')->name('sku.export')->middleware(OnlyMemberMiddleware::class);
    route::get('/sku/export', 'export')->name('sku.export');
    route::get('/sku/export/production-material','export_production_material')->name('sku.export_production_material');
    route::get('/sku/export/general-item',  'export_general_item')->name('sku.export_general_item');

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
    Route::get('/person-supplier/export', 'export_person_supplier')->name('person-supplier.export_person_supplier');

    Route::get("/person-supplier/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/person-supplier/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    // API GET ALL DATA
    Route::get("/api/person-supplier", "api_all")->middleware(OnlyMemberMiddleware::class);
    // route::get('/person-supplier/export/person-supplier', 'export_person_supplier')->name('person-supplier.export_person_supplier');
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
    Route::get("/general-terms/api/by", "get_api_by")->middleware(OnlyMemberMiddleware::class);
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
    // API GET DEPARTMENT DATA
    Route::get("/api/general-department", "api_all")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterGeneralCurrencyController::class)->group(function () {
    // LIST
    Route::get("/general-currency", "index")->middleware(OnlyMemberMiddleware::class);
    //LIST DELETED
    Route::get("/general-currency/index2", "index2")->middleware(OnlyMemberMiddleware::class);
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
    // API GET ALL DATA
    Route::get("/api/general-currency", "api_all")->middleware(OnlyMemberMiddleware::class);
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

Route::controller(MasterFactoryWarehouseController::class)->group(function () {
    // LIST
    Route::get("/factory-warehouse", "index")->middleware(OnlyMemberMiddleware::class);
    Route::get("/factory-warehouse/index2", "index2")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/factory-warehouse", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/factory-warehouse/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/factory-warehouse/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    Route::post("/factory-warehouse/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/factory-warehouse/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/factory-warehouse/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterFactoryMachineController::class)->group(function () {
    // LIST
    Route::get("/factory-machine", "index")->middleware(OnlyMemberMiddleware::class);
    Route::get("/factory-machine/index2", "index2")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/factory-machine", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/factory-machine/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/factory-machine/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    Route::post("/factory-machine/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/factory-machine/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/factory-machine/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});

Route::controller(MasterPersonEmployeeController::class)->group(function () {
    // LIST
    Route::get("/person-employee", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/person-employee", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/person-employee/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/person-employee/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    Route::post("/person-employee/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/person-employee/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/person-employee/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    // API GET ALL DATA
    Route::get("/api/person-employee", "api_all")->middleware(OnlyMemberMiddleware::class);
});

    Route::get('/person-employee/export/pdf', [MasterPersonEmployeeController::class, 'exportPdf'])->name('employee.export.pdf');
    // Route::get('/po/{id}/pdf', [PurchaseOrderController::class, 'generatePDF']);
    Route::group(['prefix' => 'po'], function () {
    Route::get('/{id}/pdf', [PurchaseOrderController::class, 'generatePDF'])->name('po.pdf');
    Route::get('/{id}/items', [PurchaseOrderController::class, 'getItems'])->name('po.items');
    Route::get('/po/{id}/items', [PurchaseOrderController::class, 'getItems']);
    // Route lainnya...
});
Route::controller(ProductionController::class)->group(function () {
    // LIST
    Route::get("/production_cycle", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/production_cycle", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/production_cycle/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/production_cycle/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    Route::post("/production_cycle/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/production_cycle/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/production_cycle/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    // API GET ALL DATA
    Route::get("/api/production_cycle", "api_all")->middleware(OnlyMemberMiddleware::class);
});
Route::controller(ProductionProcessController::class)->group(function () {
    // LIST
    Route::get("/production_process", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/production_process", "add")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/production_process/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/production_process/{id}/restore", "restore")->middleware(OnlyMemberMiddleware::class);
    Route::post("/production_process/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/production_process/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/production_process/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    // API GET ALL DATA
    Route::get("/api/production_process", "api_all")->middleware(OnlyMemberMiddleware::class);
});
   Route::controller(ProductionCostController::class)->group(function () {
    // LIST
    Route::get("/production_cost", "index")->middleware(OnlyMemberMiddleware::class);
    // ADD
    Route::post("/production_cost", "add")->middleware(OnlyMemberMiddleware::class);
    // ACTIVE DEACTIVE
    Route::post("/production_cost/active_deactive", "active_deactive")->middleware(OnlyMemberMiddleware::class);
    // DELETE
    Route::post("/production_cost/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::post("/production_cost/{id}/hapus", "hapus")->middleware(OnlyMemberMiddleware::class);
    // GET
    Route::get("/production_cost/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    // EDIT    
    Route::post("/production_cost/edit", "edit")->middleware(OnlyMemberMiddleware::class);
    // API GET ALL DATA
    Route::get("/api/production_cost", "api_all")->middleware(OnlyMemberMiddleware::class);
});

