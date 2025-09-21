<?php

namespace App\Models;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwPurchaseOrderDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'vw_app_list_trans_po_dt';

    use HasUserTracking;
}
