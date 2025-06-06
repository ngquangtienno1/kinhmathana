<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cylindrical;

class CylindricalController extends Controller
{
    public function index(Request $request)
    {
        $query = Cylindrical::query();

        if ($request->filled('search')) {
            $search = mb_strtolower(trim($request->search));
            $query->whereRaw('LOWER(value) LIKE ?', ["%{$search}%"]);
        }

        $cylindricals = $query->orderBy('sort_order')->paginate(15);

        return view('admin.cylindricals.index', compact('cylindricals'));
    }

    public function create()
    {
        return view('admin.cylindricals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric|between:-20.00,20.00|unique:cylindricals,value',
            'sort_order' => 'nullable|integer',
        ]);

        Cylindrical::create($request->only(['value', 'sort_order']));

        return redirect()->route('admin.cylindricals.index')->with('success', 'Thêm Độ loạn thành công.');
    }

    public function edit($id)
    {
        $cylindrical = Cylindrical::findOrFail($id);
        return view('admin.cylindricals.edit', compact('cylindrical'));
    }

    public function update(Request $request, $id)
    {
        $cylindrical = Cylindrical::findOrFail($id);

        $request->validate([
            'value' => 'required|numeric|between:-20.00,20.00|unique:cylindricals,value,' . $id,
            'sort_order' => 'nullable|integer',
        ]);

        $cylindrical->update($request->only(['value', 'sort_order']));

        return redirect()->route('admin.cylindricals.index')->with('success', 'Cập nhật Độ loạn thành công.');
    }

    public function destroy($id)
    {
        $cylindrical = Cylindrical::findOrFail($id);
        $cylindrical->delete();

        return redirect()->route('admin.cylindricals.index')->with('success', 'Xóa Độ loạn thành công.');
    }
}
