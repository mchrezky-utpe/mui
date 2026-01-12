<?php

namespace App\Models\Master\General;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralCurrency extends Model
{
    use SoftDeletes, HasUserTracking;

    protected $table = 'mst_general_currency';

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_by'];

    protected $fillable = [
        'description',
        'prefix',
        'flag_active',
        'flag_show',
        'created_by',
        'updated_by',
        'deleted_by',
        'manual_id',
        'generated_id',
    ];
    
    protected $casts = [
        'flag_active' => 'boolean',
        'flag_show'   => 'boolean',
    ];

    public $timestamps = false;

    public function scopeForSelect(Builder $query)
    {
        return $query->select([
            'id',
            'description',
            'prefix',
        ]);
    }
    
}
