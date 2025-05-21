<?php

namespace App\Models\Transaction\Production;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwListProducitonCostDt extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'vw_app_list_trans_prod_cost_dt';

    public $timestamps = false;

    use HasUserTracking;
}
