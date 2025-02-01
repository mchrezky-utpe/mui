<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasUserTracking;
use Carbon\Carbon;

class PurchaseOrderRequestDetail extends Model
{
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'trans_purchase_request_detail';

    use HasUserTracking;
    use HasFactory;
}
