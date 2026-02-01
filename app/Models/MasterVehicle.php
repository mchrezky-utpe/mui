<?php

namespace App\Models;

use App\Traits\TrackUserAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterVehicle extends Model
{
    use SoftDeletes, TrackUserAction;
    protected $table = 'mst_vehicle';
    protected $guarded = ['id'];
}
