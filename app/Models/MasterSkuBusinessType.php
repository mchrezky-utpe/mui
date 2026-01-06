<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class MasterSkuBusinessType extends Model
{
    use HasFactory, HasUserTracking, SoftDeletes;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'mst_sku_business_type';

    public function scopeForSelect(Builder $query)
    {
        return $query->select('id', 'description', 'prefix');
    }

}
