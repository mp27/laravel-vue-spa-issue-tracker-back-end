<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use App\Traits\HasPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole(...$roles)
    {
        // $user->hasRole('admin', 'developer');
        return $this->roles()->whereIn('slug', $roles)->count();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }



    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
