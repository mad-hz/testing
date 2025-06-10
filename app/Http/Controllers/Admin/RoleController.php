<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * A middleware for each specific method with its specific permissions
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:admin', only: ['create', 'store']),
            new Middleware('permission:admin', only: ['edit', 'update']),
            new Middleware('permission:admin', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::paginate(10);

        return view('roles.index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Show a list of the users related to a specific role
     * @param Role
     */
    public function show(Role $role)
    {
        return view('roles.show', [
            'role' => $role,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::get();

        return view('roles.create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
        ]);

        $role->updatePermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Role has been created');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $selectedPermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'selectedPermissions' => $selectedPermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $role->update([
            'name' => $request->name,
        ]);

        $role->updatePermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'role has been updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param Role
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'role has been deleted');
    }
}
