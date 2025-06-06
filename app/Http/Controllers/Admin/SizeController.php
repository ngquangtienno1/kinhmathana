<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        $query = Size::query();

        // Tìm kiếm theo tên size hoặc mô tả (không phân biệt hoa thường)
        if ($request->filled('search')) {
            $search = mb_strtolower(trim($request->search));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
            });
        }

        $sizes = $query->orderBy('sort_order')->get();

        return view('admin.sizes.index', compact('sizes'));
    }


    public function create()
    {
        return view('admin.sizes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:10',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer'
        ]);

        Size::create($request->only(['name', 'description', 'sort_order']));

        return redirect()->route('admin.sizes.index')->with('success', 'Thêm size thành công.');
    }

    public function edit($id)
    {
        $size = Size::findOrFail($id);
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:10',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer'
        ]);

        $size->update($request->only(['name', 'description', 'sort_order']));

        return redirect()->route('admin.sizes.index')->with('success', 'Cập nhật size thành công.');
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return redirect()->route('admin.sizes.index')->with('success', 'Xóa size thành công.');
    }
}