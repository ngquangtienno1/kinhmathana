<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Variation;
use App\Models\VariationImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VariationImageController extends Controller
{
    public function index(Variation $variation)
    {
        $images = $variation->images()->orderByDesc('is_thumbnail')->get();
        return view('admin.variation_images.index', compact('variation', 'images'));
    }

    public function create(Variation $variation)
    {
        return view('admin.variation_images.create', compact('variation'));
    }

    public function store(Request $request, Variation $variation)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail' => 'nullable|string'
        ], [
            'images.*.required' => 'Vui lòng chọn ít nhất một ảnh.',
            'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
            'images.*.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'images.*.max' => 'Dung lượng ảnh không được vượt quá 2MB.',
        ]);

        $hasThumbnail = $variation->images()->where('is_thumbnail', true)->exists();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('images/variations', 'public');

                $variation->images()->create([
                    'image_path' => $path,
                    'is_thumbnail' => !$hasThumbnail && $request->thumbnail === (string)$index
                ]);
            }
        }

        return redirect()->route('admin.variation_images.index', $variation->id)->with('success', 'Đã thêm ảnh thành công!');
    }

    public function destroy(Variation $variation, $id)
    {
        $image = $variation->images()->findOrFail($id);

        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();
        return redirect()->route('admin.variation_images.index', $variation->id)->with('success', 'Đã xoá ảnh!');
    }

    public function setThumbnail(Variation $variation, $id)
    {
        $image = $variation->images()->where('id', $id)->first();

        if (!$image) {
            return redirect()->back()->with('error', 'Không tìm thấy ảnh để đặt làm thumbnail!');
        }

        // Reset tất cả ảnh thumbnail về false
        $variation->images()->update(['is_thumbnail' => false]);

        // Gán thumbnail mới
        $image->update(['is_thumbnail' => true]);

        return redirect()->route('admin.variation_images.index', $variation->id)
                         ->with('success', 'Đặt ảnh thumbnail thành công!');
    }
}
