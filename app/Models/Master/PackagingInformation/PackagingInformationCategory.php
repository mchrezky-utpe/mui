<?php

namespace App\Models\Master\PackagingInformation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;

class PackagingInformationCategory extends Model
{
    use HasFactory;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'vw_app_list_mst_packaging_infromation_category';

    use HasUserTracking;
}
