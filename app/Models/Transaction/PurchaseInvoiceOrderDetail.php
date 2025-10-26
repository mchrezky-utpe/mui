<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class PurchaseInvoiceOrderDetail extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'trans_purchase_invoice_order_detail';


    use HasUserTracking;
}
