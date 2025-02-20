<?php

namespace App\Services\Master\Sku;

use App\Helpers\HelperCustom;
use App\Models\Master\Sku\SkuSubCategoryListVw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MasterSkuSubCategoryService
{
    public function droplist(){
        return SkuSubCategoryListVw::all();
    }
}