<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterPersonSupplier;
use App\Traits\HasUserTracking;

class SdsDetail extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'trans_supplier_delivery_schedule_detail';


    use HasUserTracking;
}
