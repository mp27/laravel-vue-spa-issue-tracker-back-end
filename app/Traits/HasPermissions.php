<?php

namespace App\Traits;

trait HasPermissions
{

    public function hasPermissionTo(...$permissions)
    {
        // $user->hasPermissionTo('edit-user', 'edit-issue');
        return $this->permissions()->whereIn('slug', $permissions)->count() ||
            $this->roles()->whereHas('permissions', function ($q) use ($permissions) {
                $q->whereIn('slug', $permissions);
            })->count();
    }

    public function givePermissionTo(...$permissions)
    {
        $this->permissions()->attach($permissions);
    }

    public function setPermissions(...$permissions)
    {
        $this->permissions()->sync($permissions);
    }

    public function detachPermissions(...$permissions)
    {
        $this->permissions()->detach($permissions);
    }
}
