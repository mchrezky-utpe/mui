<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\{
  SkuBusinessTypeComponent,
};

use App\Livewire\Pages\{
  ProductPrices
};

use App\Livewire\Pages\ProcessAndBusinessType\{
  ProcessClassification,
};

Route::get("/live--process-classification", ProcessClassification::class);
Route::get("/live--sku-business-type", SkuBusinessTypeComponent::class);
Route::get("/product-price", ProductPrices::class);
Route::get("/product-price/main/list/data", ProductPrices::class);