<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\{
  SkuBusinessTypeComponent,
};

use App\Livewire\Pages\{
  ProductPrices
};

use App\Livewire\Pages\ProcessAndBusinessType\{
  ProcessType,
  ProcessClassification,
};

Route::get("/live--sku-process-type", ProcessType::class);
Route::get("/live--sku-process-classification", ProcessClassification::class);
Route::get("/live--sku-business-type", SkuBusinessTypeComponent::class);
Route::get("/product-price", ProductPrices::class);
Route::get("/product-price/main/list/data", ProductPrices::class);