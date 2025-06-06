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
            $query->whereRaw('LOWER(value) LIKE ?', ["%{$search}%"]);
        }

        $sphericals = $query->orderBy('sort_order')->paginate(15);

        return view('admin.sphericals.index', compact('sphericals'));
    }

    public function create()
    {
        return view('admin.sphericals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric|between:-20.00,20.00|unique:sphericals,value',
            'sort_order' => 'nullable|integer',
        ]);

        Spherical::create($request->only(['value', 'sort_order']));

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
            'value' => 'required|numeric|between:-20.00,20.00|unique:sphericals,value,' . $id,
            'sort_order' => 'nullable|integer',
        ]);

        $spherical->update($request->only(['value', 'sort_order']));

        return redirect()->route('admin.sphericals.index')->with('success', 'Cập nhật Độ cận thành công.');
    }

    public function destroy($id)
    {
        $spherical = Spherical::findOrFail($id);
        $spherical->delete();

        return redirect()->route('admin.sphericals.index')->with('success', 'Xóa Độ cận thành công.');
    }
}
