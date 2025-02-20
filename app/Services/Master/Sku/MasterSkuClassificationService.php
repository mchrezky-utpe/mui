<?php

namespace App\Services\Master\Sku;

use App\Helpers\HelperCustom;
use App\Models\Master\Sku\SkuClassificationListVw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MasterSkuClassificationService
{
    public function droplist(){
        return SkuClassificationListVw::all();
    }
}