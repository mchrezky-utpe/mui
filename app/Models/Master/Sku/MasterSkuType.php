<?php

namespace App\Models\Master\Sku;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Helpers\HelperCustom;
// use App\Traits\HasUserTracking;
use App\Traits\TrackUserAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSkuType extends Model
{
    use SoftDeletes, TrackUserAction;
  
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $table = 'mst_sku_type';

    public function scopeForSelect(Builder $query)
    {
        return $query->select('id', 'description', 'prefix');
    }

    // protected static function booted()
    // {
    //     static::created(function ($model) {
    //         if (!$model->prefix) {
    //             $prefix = HelperCustom::generateTrxNo(self::PREFIX . "-", $model->id);
    //             $model->updateQuietly([
    //                 'prefix' => $prefix,
    //             ]);
    //         }
    //     });
    // }

    // use HasUserTracking;
}
