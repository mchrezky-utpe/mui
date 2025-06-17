<?php

namespace App\Models\Transaction\Production;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwListProductionCycle extends Model
{
    use HasFactory;

    protected $table = 'vw_app_list_trans_prod_ct';

    public $timestamps = false;

    use HasUserTracking;
}
