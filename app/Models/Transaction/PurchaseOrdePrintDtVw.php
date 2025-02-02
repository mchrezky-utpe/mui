<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterPersonSupplier;
use App\Traits\HasUserTracking;

class PurchaseOrdePrintDtVw extends Model
{
    use HasFactory;
    protected $table = 'vw_purchase_order_print_dt';
    public $timestamps = false;
    protected $guarded = [];  
}
