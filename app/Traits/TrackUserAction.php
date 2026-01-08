<?php

namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

trait TrackUserAction
{
    protected static function bootTrackUserAction()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
            $model->created_at = Carbon::now();
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
            $model->updated_at = Carbon::now();
        });

        static::deleting(function ($model) {
            // hanya untuk soft delete
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                if (Auth::check()) {
                    $model->deleted_by = Auth::id();
                }

                // ini penting supaya deleted_by ke-save
                $model->saveQuietly();
            }
        });

        static::restoring(function ($model) {
            $model->deleted_by = null;
        });
    }
}
