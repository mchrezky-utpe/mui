<?php

namespace App\Models\Transaction\Pricelist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class SkuPricelistVw extends Model
{
    use HasFactory;

    protected $table = 'vw_app_list_trans_sku_pricelist';

    use HasUserTracking;
}
