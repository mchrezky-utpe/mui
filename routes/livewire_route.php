<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\{
  SkuBusinessTypeComponent  
};

Route::get("/live--sku-business-type", SkuBusinessTypeComponent::class);