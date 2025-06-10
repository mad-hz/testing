<?php

namespace App\Models;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasPermissionsTrait, HasFactory;

    protected $fillable = [
        'name',
        'permissions',
    ];

    /**
     * A permission belongs to many roles relationship
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    /**
     * A user belongs to many roles relationship
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_roles');
    }
}
