<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Permission::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $permissions = $query->paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'description' => 'nullable|string|max:1000',
        ]);

        // Tự động tạo slug từ tên quyền
        $slug = Str::slug($validated['name']);

        // Kiểm tra nếu slug đã tồn tại
        $count = 1;
        $originalSlug = $slug;
        while (Permission::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $validated['slug'] = $slug;

        Permission::create($validated);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Thêm quyền thành công');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string|max:1000',
        ]);

        // Tự động tạo slug từ tên quyền
        $slug = Str::slug($validated['name']);

        // Kiểm tra nếu slug đã tồn tại (trừ permission hiện tại)
        $count = 1;
        $originalSlug = $slug;
        while (Permission::where('slug', $slug)->where('id', '!=', $permission->id)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $validated['slug'] = $slug;

        $permission->update($validated);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Cập nhật quyền thành công');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
