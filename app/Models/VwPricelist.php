<?php

namespace App\Models;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwPricelist extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'vw_app_list_trans_sku_pricelist';

    use HasUserTracking;
}
