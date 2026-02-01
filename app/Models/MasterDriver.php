<?php

namespace App\Models;

use App\Traits\TrackUserAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterDriver extends Model
{
    use SoftDeletes, TrackUserAction;
    protected $table = 'mst_driver';
    protected $guarded = ['id'];
}
