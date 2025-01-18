<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class PurchaseOrder extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'trans_purchase_order';

    use HasUserTracking;
}
