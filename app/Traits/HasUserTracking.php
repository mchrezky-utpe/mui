<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

trait HasUserTracking
{
    public static function bootHasUserTracking()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->created_at  = Carbon::now();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
            $model->updated_at  = Carbon::now();
        });
    }
}