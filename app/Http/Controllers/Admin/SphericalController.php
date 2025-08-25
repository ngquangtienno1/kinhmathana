<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Spherical;

class SphericalController extends Controller
{
    public function index(Request $request)
    {
        $query = Spherical::query();

        if ($request->filled('search')) {
            $search = mb_strtolower(trim($request->search));
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
        }

        $sphericals = $query->orderBy('sort_order')->get();

        return view('admin.sphericals.index', compact('sphericals'));
    }

    public function create()
    {
        return view('admin.sphericals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:10|unique:sphericals,name',
            'sort_order' => 'nullable|integer',
        ]);

        Spherical::create($request->only(['name', 'sort_order']));

        return redirect()->route('admin.sphericals.index')->with('success', 'Thêm Độ cận thành công.');
    }

    public function edit($id)
    {
        $spherical = Spherical::findOrFail($id);
        return view('admin.sphericals.edit', compact('spherical'));
    }

    public function update(Request $request, $id)
    {
        $spherical = Spherical::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:10|unique:sphericals,name,' . $id,
            'sort_order' => 'nullable|integer',
        ]);

        $spherical->update($request->only(['name', 'sort_order']));

        return redirect()->route('admin.sphericals.index')->with('success', 'Cập nhật Độ cận thành công.');
    }

    public function destroy($id)
    {
        $spherical = Spherical::findOrFail($id);

        if (!$spherical->canBeDeleted()) {
            $variationCount = $spherical->variations()->count();
            $orderCount = $spherical->orderItems()->count();

            $message = "Không thể xóa độ cận này vì nó đang được sử dụng trong {$variationCount} biến thể sản phẩm";
            if ($orderCount > 0) {
                $message .= " và {$orderCount} đơn hàng";
            }

            return redirect()->route('admin.sphericals.index')->with('error', $message);
        }

        $spherical->delete();
        return redirect()->route('admin.sphericals.index')->with('success', 'Xóa Độ cận thành công.');
    }
}
