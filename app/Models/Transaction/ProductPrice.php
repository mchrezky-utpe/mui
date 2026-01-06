<?php

namespace App\Models\Transaction;

use App\Models\MasterSku;
use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use HasUserTracking, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    public function sku()
    {
        return $this->belongsTo(MasterSku::class);
    }
}
