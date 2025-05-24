<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variation;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;

class VariationController extends Controller
{
    public function index(Request $request)
    {
        $query = Variation::with(['product', 'variationDetails.color', 'variationDetails.size', 'images']);

        // 🔍 Tìm kiếm
        if ($request->filled('search')) {
            $search = mb_strtolower(trim($request->search));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(sku) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('CAST(id AS CHAR) LIKE ?', ["%{$search}%"])
                  ->orWhereHas('product', function ($subQ) use ($search) {
                      $subQ->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                  });
            });
        }

        // 📦 Lọc hết hàng
        if ($request->filter === 'out_of_stock') {
            $query->where('stock_quantity', '<=', 0);
        }

        $variations = $query->latest()->paginate(10);

        return view('admin.variations.index', compact('variations'));
    }

    public function create()
    {
        $products = Product::all();
        $colors = Color::orderBy('sort_order')->get();
        $sizes = Size::orderBy('sort_order')->get();

        return view('admin.variations.create', compact('products', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:125',
            'sku' => 'required|string|unique:variations,sku',
            'price' => 'required|numeric',
            'import_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock_quantity' => 'nullable|integer|min:0',
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
        ], [
            'product_id.required' => 'Vui lòng chọn sản phẩm cha.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'name.required' => 'Tên biến thể không được để trống.',
            'sku.required' => 'Mã SKU là bắt buộc.',
            'sku.unique' => 'Mã SKU đã tồn tại.',
            'price.required' => 'Giá gốc là bắt buộc.',
            'import_price.required' => 'Giá nhập là bắt buộc.',
            'sale_price.required' => 'Giá bán là bắt buộc.',
            'stock_quantity.integer' => 'Số lượng tồn phải là số nguyên.',
            'color_id.exists' => 'Màu không hợp lệ.',
            'size_id.exists' => 'Kích thước không hợp lệ.'
        ]);

        $variation = Variation::create($request->only([
            'product_id', 'name', 'sku', 'price', 'import_price',
            'sale_price', 'stock_quantity'
        ]));

        if ($request->filled('color_id') || $request->filled('size_id')) {
            $variation->variationDetails()->create([
                'color_id' => $request->input('color_id'),
                'size_id' => $request->input('size_id'),
            ]);
        }

        return redirect()->route('admin.variations.index')->with('success', 'Tạo biến thể thành công!');
    }

    public function show(Variation $variation)
    {
        $variation->load(['product', 'variationDetails.color', 'variationDetails.size', 'images']);
        return view('admin.variations.show', compact('variation'));
    }

    public function edit(Variation $variation)
    {
        $products = Product::all();
        $colors = Color::orderBy('sort_order')->get();
        $sizes = Size::orderBy('sort_order')->get();
        $variation->load('variationDetails');

        return view('admin.variations.edit', compact('variation', 'products', 'colors', 'sizes'));
    }

    public function update(Request $request, Variation $variation)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:125',
            'price' => 'required|numeric',
            'import_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock_quantity' => 'nullable|integer|min:0',
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
        ], [
            'product_id.required' => 'Vui lòng chọn sản phẩm cha.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'name.required' => 'Tên biến thể không được để trống.',
            'price.required' => 'Giá gốc là bắt buộc.',
            'import_price.required' => 'Giá nhập là bắt buộc.',
            'sale_price.required' => 'Giá bán là bắt buộc.',
            'stock_quantity.integer' => 'Số lượng tồn phải là số nguyên.',
            'color_id.exists' => 'Màu không hợp lệ.',
            'size_id.exists' => 'Kích thước không hợp lệ.'
        ]);

        $variation->update($request->only([
            'product_id', 'name', 'sku', 'price', 'import_price', 'sale_price', 'stock_quantity'
        ]));

        $detail = $variation->variationDetails()->first();
        if ($detail) {
            $detail->update([
                'color_id' => $request->input('color_id'),
                'size_id' => $request->input('size_id'),
            ]);
        } else {
            if ($request->filled('color_id') || $request->filled('size_id')) {
                $variation->variationDetails()->create([
                    'color_id' => $request->input('color_id'),
                    'size_id' => $request->input('size_id'),
                ]);
            }
        }

        return redirect()->route('admin.variations.index')->with('success', 'Cập nhật biến thể thành công!');
    }

    public function destroy(Variation $variation)
    {
        $variation->delete();
        return redirect()->route('admin.variations.index')->with('success', 'Đã xóa (soft delete) biến thể!');
    }

    public function bin()
    {
        $trashed = Variation::onlyTrashed()->with('product')->paginate(10);
        return view('admin.variations.bin', compact('trashed'));
    }

    public function restore($id)
    {
        $variation = Variation::onlyTrashed()->findOrFail($id);
        $variation->restore();
        return redirect()->route('admin.variations.bin')->with('success', 'Khôi phục thành công!');
    }

    public function forceDelete($id)
    {
        $variation = Variation::onlyTrashed()->findOrFail($id);

        // Xoá ảnh vật lý nếu có
        foreach ($variation->images as $image) {
            if ($image->image_path && \Storage::disk('public')->exists($image->image_path)) {
                \Storage::disk('public')->delete($image->image_path);
            }
        }

        $variation->forceDelete();
        return redirect()->route('admin.variations.bin')->with('success', 'Đã xóa vĩnh viễn!');
    }
}
