<?php

namespace App\Models;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Model;

class MasterSkuProcessClassification extends Model
{
    //
    use HasUserTracking;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by', ];
    protected $table = "mst_sku_process_classification";

    public function process_type() {
       return $this->belongsTo(MasterSkuProcessType::class, 'mst_sku_process_type_id'); 
    }
}
