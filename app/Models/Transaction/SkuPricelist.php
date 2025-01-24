<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;
use  App\Models\MasterSku;
use  App\Models\MasterPersonSupplier;
use  App\Models\MasterGeneralCurrency;


class SkuPricelist extends Model
{
    use HasFactory;

    use HasUserTracking;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'trans_sku_pricelist';

    public function sku()
    {
        return $this->hasOne(MasterSku::class, 'id','sku_id');
    }

    public function supplier()
    {
        return $this->hasOne(MasterPersonSupplier::class, 'id','prs_supplier_id');
    }

    public function currency()
    {
        return $this->hasOne(MasterGeneralCurrency::class, 'id','gen_currency_id');
    }
}
