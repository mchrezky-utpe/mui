<?php

namespace App\Models;

use App\Models\Master\Sku\MasterSkuType;
use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterSkuProcessType extends Model
{
    use HasFactory;
    use HasUserTracking;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by', ];
    protected $table = "mst_sku_process_type";

    public function item_type() {
        return $this->belongsTo(MasterSkuType::class, 'item_type_id');
    }
}
