<?php

namespace App\Services\Master\Sku;

use App\Helpers\HelperCustom;
use App\Models\Master\Sku\SkuSalesListVw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MasterSkuSalesService
{
    public function droplist(){
        return SkuSalesListVw::all();
    }
}