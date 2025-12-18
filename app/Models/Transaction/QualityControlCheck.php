<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class QualityControlCheck extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'trans_quality_control_check';


    use HasUserTracking;
}
