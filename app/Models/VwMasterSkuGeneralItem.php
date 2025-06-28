<?php

namespace App\Models;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwMasterSkuGeneralItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'vw_export_sku_general_item';

    use HasUserTracking;
}
