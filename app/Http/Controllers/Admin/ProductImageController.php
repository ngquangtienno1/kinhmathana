<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        $images = $product->images()->orderByDesc('is_thumbnail')->get();

        return view('admin.product_images.index', compact('product', 'images'));
    }

    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        return view('admin.product_images.create', compact('product'));
    }

   public function store(Request $request, $productId)
{
    $request->validate([
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        'thumbnail' => 'nullable|string',
    ], [
        'images.*.required' => 'Vui lòng chọn ít nhất một ảnh.',
        'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
        'images.*.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, svg, webp.',
        'images.*.max' => 'Ảnh không được vượt quá 4MB.',
    ]);

    $product = Product::findOrFail($productId);
    $hasThumbnail = $product->images()->where('is_thumbnail', true)->exists();

    foreach ($request->file('images') as $index => $image) {
        $path = $image->store('images/products', 'public');

        ProductImage::create([
            'product_id' => $productId,
            'image_path' => $path,
            'is_thumbnail' => !$hasThumbnail && $request->thumbnail === (string) $index
        ]);
    }

    return redirect()->route('admin.product_images.index', $productId)->with('success', 'Thêm ảnh thành công.');
}


    public function edit($productId, $id)
    {
        $product = Product::findOrFail($productId);
        $image = ProductImage::where('product_id', $productId)->findOrFail($id);
        return view('admin.product_images.edit', compact('product', 'image'));
    }

    public function update(Request $request, $productId, $id)
    {
        $image = ProductImage::where('product_id', $productId)->findOrFail($id);

        $image->is_thumbnail = $request->has('is_thumbnail');
        $image->save();

        if ($image->is_thumbnail) {
            ProductImage::where('product_id', $image->product_id)
                ->where('id', '!=', $image->id)
                ->update(['is_thumbnail' => false]);
        }

        return redirect()->route('admin.product_images.index', $productId)->with('success', 'Cập nhật ảnh thành công.');
    }

    public function destroy($productId, $id)
    {
        $image = ProductImage::where('product_id', $productId)->findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()->route('admin.product_images.index', $productId)->with('success', 'Xóa ảnh thành công.');
    }

    public function setThumbnail($productId, $id)
    {
        $image = ProductImage::where('product_id', $productId)->findOrFail($id);

        ProductImage::where('product_id', $image->product_id)
            ->update(['is_thumbnail' => false]);

        $image->is_thumbnail = true;
        $image->save();

        return redirect()->route('admin.product_images.index', $productId)->with('success', 'Đặt ảnh làm thumbnail thành công.');
    }
}
