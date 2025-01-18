<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transaction\PurchaseOrderController;
use App\Http\Middleware\OnlyMemberMiddleware;

Route::controller(PurchaseOrderController::class)->group(function () {
    Route::get("/po", "index")->middleware(OnlyMemberMiddleware::class);
    Route::post("/po", "add")->middleware(OnlyMemberMiddleware::class);
    Route::post("/po/{id}/delete", "delete")->middleware(OnlyMemberMiddleware::class);
    Route::get("/po/{id}", "get")->middleware(OnlyMemberMiddleware::class);
    Route::post("/po/edit", "edit")->middleware(OnlyMemberMiddleware::class);
});
