<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customor extends Model
{
    use SoftDeletes, HasUserTracking;
    protected $table = 'mst_customer';
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    
}
