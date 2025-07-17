<?php

namespace App\Models;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwExportMasterPerson extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'vw_app_export_mst_person_supplier';

    use HasUserTracking;
}
