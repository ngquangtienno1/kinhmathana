<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::with('permissions');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $roles = $query->paginate(10);
        $totalPermissions = \App\Models\Permission::count();

        return view('admin.roles.index', compact('roles', 'totalPermissions'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('group_permissions');
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:1000',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ], [
            'name.required' => 'Vui lòng nhập tên vai trò',
            'name.unique' => 'Tên vai trò đã tồn tại',
            'permissions.required' => 'Vui lòng chọn ít nhất một quyền',
            'permissions.*.exists' => 'Quyền không hợp lệ'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            $role->permissions()->attach($request->permissions);

            DB::commit();

            return redirect()->route('admin.roles.index')
                ->with('success', 'Thêm vai trò thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy('group_permissions');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:1000',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ], [
            'name.required' => 'Vui lòng nhập tên vai trò',
            'name.unique' => 'Tên vai trò đã tồn tại',
            'permissions.required' => 'Vui lòng chọn ít nhất một quyền',
            'permissions.*.exists' => 'Quyền không hợp lệ'
        ]);

        try {
            DB::beginTransaction();

            $role->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            $role->permissions()->sync($request->permissions);

            DB::commit();

            return redirect()->route('admin.roles.index')
                ->with('success', 'Cập nhật vai trò thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Không thể xóa vai trò này vì đang có người dùng sử dụng.');
        }

        DB::beginTransaction();
        try {
            $role->permissions()->detach();
            $role->delete();

            DB::commit();
            return redirect()->route('admin.roles.index')
                ->with('success', 'Vai trò đã được xóa thành công.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Có lỗi xảy ra khi xóa vai trò.');
        }
    }
}
