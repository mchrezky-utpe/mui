<?php

namespace App\Models\Transaction\Production;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionProcess extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'trans_production_process_information';

    public $timestamps = false;

    use HasUserTracking;
}
