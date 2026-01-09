<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Sku\MasterSkuType;
use App\Traits\TrackUserAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSkuProcessType extends Model
{
    use SoftDeletes, TrackUserAction;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by', ];
    protected $table = "mst_sku_process_type";

    public const string PREFIX = "PTC";

    public function item_type() {
        return $this->belongsTo(MasterSkuType::class, 'mst_sku_type_id');
    }

    public function scopeForSelect(Builder $query)
    {
        return $query->select('id', 'description', 'prefix');
    }

    protected static function booted()
    {
        static::created(function ($model) {
            if (!$model->prefix) {
                $prefix = self::PREFIX;
                $model->updateQuietly([
                    'prefix' => "{$prefix}-{$model->id}"
                ]);
            }
        });
    }
}
