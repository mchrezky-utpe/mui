<?php

namespace App\Models\Master\Bom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class BomDetail extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'mst_sku_bom_detail';

    use HasUserTracking;

    public function sku()
{
    return $this->belongsTo(\App\Models\MasterSku::class, 'sku_id');
}

}
