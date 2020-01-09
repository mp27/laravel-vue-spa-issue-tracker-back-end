<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $userRoles = $this->roles()->with('permissions')->get();
        $roles = $userRoles->pluck('slug');
        $rolesPermissions = $userRoles->pluck('permissions')->flatten(1)->pluck('slug');
        $userPermissions = $rolesPermissions->merge($this->permissions->pluck('slug'));

        return [
            "name" => $this->name,
            "email" => $this->email,
            "created_at" => $this->created_at->format('Y-m-d'),
            "roles" => $roles,
            "permissions" => $userPermissions,
        ];
    }
}
