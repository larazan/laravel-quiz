<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
    //
    public function index(Request $request)
    {
        // 🔎 Search + Pagination (for main permission table)
        $permissions = Permission::when($request->search, function ($query, $search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        // 📦 Group permissions (for group UI + role assignment)
        $groups = Permission::orderBy('group')
            ->orderBy('name')
            ->get()
            ->groupBy('group')
            ->map(function ($permissions, $groupName) {
                return [
                    'group' => $groupName,
                    'permissions' => $permissions->map(function ($p) {
                        return [
                            'id' => $p->id,
                            'name' => $p->name,
                            'guard_name' => $p->guard_name,
                        ];
                    })->values()
                ];
            })
            ->values();

        // 📌 For Assign Permission to Role modal
        $roles = Role::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Admin/Permissions/Index', [
            'permissions' => $permissions,
            'filters' => $request->only(['search']),
            'groups' => $groups,
            'roles' => $roles,
        ]);
    }

    // 🟢 Create Permission
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:permissions,name'],
            'group' => ['required'],
        ]);

        Permission::create([
            'name' => $request->name,
            'group' => $request->group,
            'guard_name' => 'web',
        ]);

        return back()->with('success', 'Permission created successfully.');
    }

    // 🟡 Update Permission
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => "required|unique:permissions,name,{$id}",
            'group' => ['required'],
        ]);

        $permission->update([
            'name' => $request->name,
            'group' => $request->group,
        ]);

        return back()->with('success', 'Permission updated successfully.');
    }

    // 🔴 Delete Permission
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return back()->with('success', 'Permission deleted successfully.');
    }

    // 🔄 Assign multiple permissions to a role
    public function syncRolePermissions(Request $request)
    {
        $request->validate([
            'role_id' => ['required'],
            'permission_ids' => ['array'],
        ]);

        $role = Role::findOrFail($request->role_id);

        // Sync!
        $role->syncPermissions($request->permission_ids ?? []);

        return back()->with('success', 'Permissions updated for role.');
    }
}
