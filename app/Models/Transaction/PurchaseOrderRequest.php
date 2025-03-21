<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterPersonSupplier;
use App\Traits\HasUserTracking;

class PurchaseOrderRequest extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'trans_purchase_request';

    
    public function items()
    {
        return $this->hasMany(PurchaseOrderRequestDetail::class, 'trans_pr_id','id');
    }


    use HasUserTracking;
}
