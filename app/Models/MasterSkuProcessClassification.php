<?php

namespace App\Models;

use App\Helpers\HelperCustom;
use App\Traits\TrackUserAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSkuProcessClassification extends Model
{
    //
    // use HasUserTracking;
    use SoftDeletes, TrackUserAction;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by', ];
    protected $table = "mst_sku_process_classification";

    public const string PREFIX = "PCC";

    public function process_type() {
       return $this->belongsTo(MasterSkuProcessType::class, 'mst_sku_process_type_id'); 
    }

    public function scopeForSelect(Builder $query)
    {
        return $query->select('id', 'description', 'prefix');
    }

    protected static function booted()
    {
        static::created(function ($model) {
            if (!$model->prefix) {
                $prefix = HelperCustom::generateTrxNo(self::PREFIX . "-", $model->id);
                $model->updateQuietly([
                    'prefix' => $prefix,
                ]);
            }
        });
    }
}
