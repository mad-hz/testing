<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'create roles'
            ],
            [
                'name' => 'edit roles'
            ],
            [
                'name' => 'delete roles'
            ],
            [
                'name' => 'edit users'
            ],
            [
                'name' => 'delete users',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::factory()->create($permission);
        }
    }
}
