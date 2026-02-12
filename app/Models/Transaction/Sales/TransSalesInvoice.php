<?php

namespace App\Models\Transaction\Sales;

use Illuminate\Database\Eloquent\Model;

class TransSalesInvoice extends Model
{

    protected $table = 'trans_sales_invoice';
    protected $guarded = ["id"];
}
