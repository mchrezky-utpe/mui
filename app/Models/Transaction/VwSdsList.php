<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterPersonSupplier;
use App\Traits\HasUserTracking;

class VwSdsList extends Model
{
    use HasFactory;
  
    protected $table = 'vw_app_list_trans_sds_hd';


}
