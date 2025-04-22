<?php

namespace App\Models;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPersonEmployee extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'mst_employee';

    public $timestamps = false;

    use HasUserTracking;
}
