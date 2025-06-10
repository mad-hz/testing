<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * A role belongs to many permissions relationship
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }

    /**
     * A user belongs to many roles relationship
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_permissions');
    }
}
