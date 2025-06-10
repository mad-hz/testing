<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use function Pest\Laravel\{actingAs, seed};
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    seed();

    // $this->admin = User::factory()->create(['id' => 1]);
    $this->admin = User::where('email', 'test@example.com')->first();

    $role = Role::where('name', 'admin')->first();
    $this->admin->roles()->sync($role);
});

test('admin can create role with permissions', function () {
    $permissions = Permission::limit(2)->pluck('id');

    actingAs($this->admin)
        ->post(route('roles.store'), [
            'name' => 'Editor',
            'permissions' => $permissions->toArray(),
        ])
        ->assertRedirect();

    $role = Role::where('name', 'Editor')->first();
    expect($role)->not->toBeNull();
    expect($role->permissions)->toHaveCount(2);
});

test('admin can update role permissions', function () {
    $role = Role::factory()->create(['name' => 'Temporary Role']);
    $newPermissions = Permission::limit(3)->pluck('id');

    actingAs($this->admin)
        ->put(route('roles.update', $role), [
            'name' => 'Updated Role',
            'permissions' => $newPermissions->toArray()
        ]);

    $updated = $role->fresh();

    expect($updated->name)->toBe('Updated Role');
    expect($updated->permissions)->toHaveCount(3);
});


test('admin can delete role', function () {
    $role = Role::factory()->create();

    actingAs($this->admin)
        ->delete(route('roles.destroy', $role))
        ->assertRedirect();

    $this->assertDatabaseMissing('roles', ['id' => $role->id]);
});

test('regular user cannot access protected role routes', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();

    actingAs($user)
        ->get(route('roles.create'))
        ->assertForbidden();

    actingAs($user)
        ->post(route('roles.store'))
        ->assertForbidden();

    actingAs($user)
        ->get(route('roles.edit', $role))
        ->assertForbidden();

    actingAs($user)
        ->put(route('roles.update', $role))
        ->assertForbidden();

    actingAs($user)
        ->delete(route('roles.destroy', $role))
        ->assertForbidden();
});
