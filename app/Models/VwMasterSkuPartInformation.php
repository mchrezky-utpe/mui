<?php

namespace App\Models;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwMasterSkuPartInformation extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'vw_export_sku_part_information';

    use HasUserTracking;
}
