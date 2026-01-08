<?php

namespace App\Models\Transaction;

use App\Models\MasterSku;
use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use SoftDeletes, HasUserTracking;

    protected $table = "trans_sku_product_prices";

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    public function sku()
    {
        return $this->belongsTo(MasterSku::class);
    }

    public $cast = [
        "price" => "double:2",
        "retail_price" => "double:2",
        "effective_from" => "date",
        "effective_to" => "date",
    ];
}
