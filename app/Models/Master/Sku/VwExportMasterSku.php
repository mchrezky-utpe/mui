<?php

namespace App\Models\Master\Sku;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwExportMasterSku extends Model
{
    use HasFactory;
    protected $table = 'vw_app_export_mst_sku';
    public $timestamps = false;
    protected $guarded = [];  
}
