<?php

namespace App\Models;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwMasterSkuProductionMaterial extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'vw_export_sku_production_material';

    use HasUserTracking;
}
