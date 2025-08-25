<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        $query = Color::query();

        // Tìm kiếm không phân biệt hoa thường và hỗ trợ tiếng Việt
        if ($request->filled('search')) {
            $search = mb_strtolower(trim($request->search));

            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(hex_code) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('CAST(id AS CHAR) LIKE ?', ["%{$search}%"]);
            });
        }

        $colors = $query->orderBy('sort_order')->get();

        return view('admin.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'hex_code' => 'required|string|max:10',
            'image_url' => 'nullable|url',
            'sort_order' => 'nullable|integer'
        ]);

        Color::create($request->only(['name', 'hex_code', 'image_url', 'sort_order']));

        return redirect()->route('admin.colors.index')->with('success', 'Thêm màu thành công.');
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50',
            'hex_code' => 'required|string|max:10',
            'image_url' => 'nullable|url',
            'sort_order' => 'nullable|integer'
        ]);

        $color->update($request->only(['name', 'hex_code', 'image_url', 'sort_order']));

        return redirect()->route('admin.colors.index')->with('success', 'Cập nhật màu thành công.');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);

        // Kiểm tra xem color có được sử dụng trong variations không
        if (!$color->canBeDeleted()) {
            $variationCount = $color->variations()->count();
            $orderCount = $color->orderItems()->count();

            $message = "Không thể xóa màu sắc này vì nó đang được sử dụng trong {$variationCount} biến thể sản phẩm";
            if ($orderCount > 0) {
                $message .= " và {$orderCount} đơn hàng";
            }
            return redirect()->route('admin.colors.index')->with('error', $message);
        }

        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'Xóa màu thành công.');
    }
}