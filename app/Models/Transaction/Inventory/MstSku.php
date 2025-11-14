<?php

namespace App\Models\Transaction\Inventory;

use Illuminate\Database\Eloquent\Model;

class MstSku extends Model
{
    
    protected $table = 'mst_sku';
    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(MstSkuType::class, 'sku_type_id');
    }
}
