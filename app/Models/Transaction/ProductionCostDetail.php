<?php

namespace App\Models\Transaction;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionCostDetail extends Model
{
    use HasFactory;
  

    protected $table = 'vw_app_list_trans_prod_cost_dt';

    public $timestamps = false;

    use HasUserTracking;
}
