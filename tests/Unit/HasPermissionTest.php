<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('updatePermissions syncs permissions correctly', function () {
    $user = User::factory()->create();
    $permissions = Permission::factory()->count(3)->create();

    $user->updatePermissions($permissions->pluck('id')->toArray());

    expect($user->permissions)->toHaveCount(3);
});

test('hasPermissionTo checks direct permission', function () {
    $user = User::factory()->create();
    $permission = Permission::factory()->create();

    $user->permissions()->attach($permission);

    expect($user->hasPermissionTo($permission))->toBeTrue();
});

test('hasPermissionTo checks permission through role', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();
    $permission = Permission::factory()->create();

    $user->roles()->attach($role);
    $role->permissions()->attach($permission);

    expect($user->hasPermissionTo($permission))->toBeTrue();
});

test('hasRole checks assigned roles', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create(['name' => 'admin']);

    $user->roles()->attach($role);

    expect($user->hasRole('admin'))->toBeTrue()
        ->and($user->hasRole('editor'))->toBeFalse();
});
