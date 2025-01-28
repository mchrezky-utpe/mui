<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterPersonSupplier;
use App\Traits\HasUserTracking;

class PurchaseOrder extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'trans_purchase_order';

    
    public function supplier()
    {
        return $this->hasOne(MasterPersonSupplier::class, 'id','prs_supplier_id');
    }


    use HasUserTracking;
}
