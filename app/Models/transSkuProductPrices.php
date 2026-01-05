<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transSkuProductPrices extends Model
{
    protected $table = "trans_sku_product_prices";
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    public function priceable() {
        $this->morphTo();
    }

    // idk yet
    public function customor() {
        $this->belongsTo('','customor_id','id');
    }


}
