<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'mst_role';
    public $timestamps = false;

    protected $fillable = [
        'role_code',
        'role_name',
        'description',
        'flag_active',
        'created_by',
        'created_at'
    ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'mst_user_role',
            'role_id',
            'user_id'
        );
    }
}
