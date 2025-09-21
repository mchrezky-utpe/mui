<?php

namespace App\Models;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwGeneralPurchaseOrder extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'vw_app_list_trans_rr_gpo_dt';

    use HasUserTracking;
}
