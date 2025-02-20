<?php

namespace App\Models\Master\Sku;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class SkuCategoryListVw extends Model
{
    protected $table = 'vw_app_list_mst_sku_category';
    public $timestamps = false;
    protected $guarded = [];  
}
