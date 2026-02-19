<?php

namespace App\Models;

use App\Models\Role;
use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;


    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password'
    ];

    protected $table = 'mst_user';

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'mst_user_role',
            'user_id',
            'role_id'
        );
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('role_name', $roleName)->exists();
    }


    use HasUserTracking;
}
