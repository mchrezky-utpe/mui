<?php

namespace App\Models\Transaction\Inventory;

use Illuminate\Database\Eloquent\Model;

class MstSkuType extends Model
{
    protected $table = 'mst_sku_type';
    protected $guarded = [];

    public function subCategory()
    {
        return $this->belongsTo(MstSkuSubCategory::class, 'sku_sub_category_id');
    }
}
