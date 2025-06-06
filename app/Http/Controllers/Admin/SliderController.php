<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\NotificationController;

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

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $sliders = $query->orderBy('sort_order', 'asc')->get();
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
            $messages = [
                'title.required' => 'Vui lòng nhập tiêu đề',
                'title.max' => 'Tiêu đề không được vượt quá 125 ký tự',
                'image.required' => 'Vui lòng chọn hình ảnh',
                'image.image' => 'File phải là hình ảnh',
                'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
                'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
                'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên',
                'start_date.date' => 'Ngày bắt đầu không hợp lệ',
                'end_date.date' => 'Ngày kết thúc không hợp lệ',
                'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
                'url.url' => 'URL không hợp lệ'
            ];

            $dataNew = $request->validate([
                'title' => 'required|string|max:125',
                'description' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'url' => 'nullable|url|max:255',
                'sort_order' => 'nullable|integer',
                'is_active' => 'nullable|boolean',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date'
            ], $messages);

            $dataNew['is_active'] = $request->boolean('is_active');

            // Lưu ảnh
            if ($request->hasFile('image')) {
                $imgPath = $request->file('image')->store('images/sliders', 'public');
                $dataNew['image'] = $imgPath;
            }

            $slider = Slider::create($dataNew);

            // Gửi thông báo cho admin
            $notificationController = new NotificationController();
            $notificationController->notifyNewSlider($slider);

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

            $messages = [
                'title.required' => 'Vui lòng nhập tiêu đề',
                'title.max' => 'Tiêu đề không được vượt quá 125 ký tự',
                'image.image' => 'File phải là hình ảnh',
                'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
                'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
                'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên',
                'start_date.date' => 'Ngày bắt đầu không hợp lệ',
                'end_date.date' => 'Ngày kết thúc không hợp lệ',
                'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
                'url.url' => 'URL không hợp lệ'
            ];

            $dataNew = $request->validate([
                'title' => 'required|string|max:125',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'url' => 'nullable|url|max:255',
                'sort_order' => 'nullable|integer',
                'is_active' => 'nullable|boolean',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date'
            ], $messages);

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
            return redirect()->route('admin.sliders.index')->with('success', 'Xóa slider thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa slider: ' . $e->getMessage());
        }
    }

    public function bin()
    {
        $sliders = Slider::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
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

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một slider để xóa.');
        }
        try {
            Slider::whereIn('id', $ids)->delete();
            return redirect()->route('admin.sliders.index')->with('success', 'Đã xóa mềm các slider đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa: ' . $e->getMessage());
        }
    }

    public function bulkRestore(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một slider để khôi phục.');
        }
        try {
            Slider::onlyTrashed()->whereIn('id', $ids)->restore();
            return redirect()->route('admin.sliders.bin')->with('success', 'Đã khôi phục các slider đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi khôi phục: ' . $e->getMessage());
        }
    }

    public function bulkForceDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một slider để xóa vĩnh viễn.');
        }
        try {
            $sliders = Slider::withTrashed()->whereIn('id', $ids)->get();
            foreach ($sliders as $slider) {
                if ($slider->image) {
                    \Storage::disk('public')->delete($slider->image);
                }
                $slider->forceDelete();
            }
            return redirect()->route('admin.sliders.bin')->with('success', 'Đã xóa vĩnh viễn các slider đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn: ' . $e->getMessage());
        }
    }
}