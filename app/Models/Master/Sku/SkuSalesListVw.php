<?php

namespace App\Models\Master\Sku;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class SkuSalesListVw extends Model
{
    protected $table = 'vw_app_list_mst_sku_sales_category';
    public $timestamps = false;
    protected $guarded = [];  
}
