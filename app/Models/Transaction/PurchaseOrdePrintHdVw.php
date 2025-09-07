<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrdePrintHdVw extends Model
{
    protected $table = 'vw_purchase_order_print_hd';
    public $timestamps = false;
    protected $guarded = [];  
}
