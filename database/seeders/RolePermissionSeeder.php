<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        $permissions = [
            'create roles',
            'edit roles',
            'delete roles',
            'edit users',
            'delete users',
        ];

        if ($adminRole) {
            $permissionIds = Permission::whereIn('name', $permissions)->pluck('id')->toArray();

            $adminRole->permissions()->syncWithoutDetaching($permissionIds);
        }
    }
}
