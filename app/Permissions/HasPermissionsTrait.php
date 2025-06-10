<?php

namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Arr;

trait HasPermissionsTrait
{
    /**
     * Update permissions
     */
    public function updatePermissions(...$permissions)
    {
        $permissions = Arr::flatten($permissions);

        $this->permissions()->detach();

        if (!empty($permissions)) {
            $this->permissions()->sync($permissions);
        }

        return $this;
    }

    /**
     * Check if the user has a specific permission
     * @return boolean
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    /**
     * Check if the user has a specific role
     * @return boolean
     */
    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Permission
     */
    protected function getPermissions(array $permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }

    /**
     * @return boolean depending if the user has a permission through a role
     */
    protected function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return boolean depending if we have a record of the user's permission
     */
    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)->count();
    }

    /**
     * A user belongs to many roles relationship
     * @return relationship
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * A user belongs to many permissions relationship
     * @return relationship
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }
}
