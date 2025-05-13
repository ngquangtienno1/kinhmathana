<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $query = Slider::query();

        // Tìm kiếm theo tiêu đề hoặc mô tả
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $sliders = $query->orderBy('sort_order', 'asc')->paginate(10);
        $deletedCount = Slider::onlyTrashed()->count();
        $activeCount = Slider::where('is_active', true)->count();

        return view('admin.sliders.index', compact('sliders', 'deletedCount', 'activeCount'));
    }

    public function show($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.show', compact('slider'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        try {
            $dataNew = $request->validate([
                'title' => 'required|string|max:125',
                'description' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'sort_order' => 'nullable|integer',
                'is_active' => 'required|boolean'
            ]);

            // Lưu ảnh
            if ($request->hasFile('image')) {
                $imgPath = $request->file('image')->store('images/sliders', 'public');
                $dataNew['image'] = $imgPath;
            }

            Slider::create($dataNew);
            return redirect()->route('admin.sliders.index')->with('success', 'Thêm slider thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm slider: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        try {
            $slider = Slider::findOrFail($id);

            $dataNew = $request->validate([
                'title' => 'required|string|max:125',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'sort_order' => 'nullable|integer',
                'is_active' => 'required|boolean'
            ]);

            if ($request->hasFile('image')) {
                $imgPath = $request->file('image')->store('images/sliders', 'public');

                // Xóa ảnh cũ nếu có
                if ($slider->image) {
                    Storage::disk('public')->delete($slider->image);
                }

                $dataNew['image'] = $imgPath;
            }

            $slider->update($dataNew);
            return redirect()->route('admin.sliders.index')->with('success', 'Cập nhật slider thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật slider: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $slider->delete(); // Soft delete
            return redirect()->route('admin.sliders.index')->with('error', 'Xóa slider thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa slider: ' . $e->getMessage());
        }
    }

    public function bin()
    {
        $sliders = Slider::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return view('admin.sliders.bin', compact('sliders'));
    }

    public function restore($id)
    {
        try {
            $slider = Slider::onlyTrashed()->findOrFail($id);
            $slider->restore();
            return redirect()->route('admin.sliders.bin')->with('success', 'Khôi phục slider thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi khôi phục slider: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $slider = Slider::withTrashed()->findOrFail($id);

            // Xóa ảnh nếu có
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }

            $slider->forceDelete();
            return redirect()->route('admin.sliders.bin')->with('error', 'Xóa vĩnh viễn slider thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn slider: ' . $e->getMessage());
        }
    }
    public function bulkDelete(Request $request)
    {
        try {
            $ids = json_decode($request->ids);

            if (empty($ids)) {
                return redirect()->back()->with('error', 'Không có slider nào được chọn');
            }

            Slider::whereIn('id', $ids)->delete();

            return redirect()->back()->with('success', 'Đã xóa mềm các slider đã chọn thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa mềm các slider');
        }
    }
}