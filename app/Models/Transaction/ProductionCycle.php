<?php

namespace App\Models\Transaction;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionCycle extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'trans_production_cycle_time';

    public $timestamps = false;

    use HasUserTracking;
}
