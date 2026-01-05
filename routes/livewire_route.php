<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\{
  SkuBusinessTypeComponent,
};

use App\Livewire\Pages\{
  ProductPrices
};


Route::get("/live--sku-business-type", SkuBusinessTypeComponent::class);
Route::get("/product-price", ProductPrices::class);