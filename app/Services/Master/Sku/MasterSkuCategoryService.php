<?php

namespace App\Services\Master\Sku;

use App\Helpers\HelperCustom;
use App\Models\Master\Sku\SkuCategoryListVw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MasterSkuCategoryService
{
    public function droplist(){
        return SkuCategoryListVw::all();
    }
}