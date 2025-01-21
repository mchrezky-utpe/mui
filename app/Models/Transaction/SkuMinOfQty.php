<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;
use  App\Models\MasterSku;

class SkuMinOfQty extends Model
{
    use HasFactory;

    use HasUserTracking;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'trans_sku_minofqty';


    public function sku()
    {
        return $this->hasOne(MasterSku::class, 'id','sku_id');
    }
}
