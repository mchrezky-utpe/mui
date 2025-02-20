<?php

namespace App\Models\Master\Sku;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class SkuUnitListVw extends Model
{
    protected $table = 'vw_app_list_mst_sku_unit';
    public $timestamps = false;
    protected $guarded = [];  
}
