<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Tìm kiếm không phân biệt hoa thường và hỗ trợ tiếng Việt
        if ($request->filled('search')) {
            $search = mb_strtolower(trim($request->search));

            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(description_short) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('CAST(id AS CHAR) LIKE ?', ["%{$search}%"])
                    ->orWhereHas('category', function ($subQ) use ($search) {
                        $subQ->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                    })
                    ->orWhereHas('brand', function ($subQ) use ($search) {
                        $subQ->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                    });
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            if ($request->status === 'Hoạt động') {
                $query->where('status', 'Hoạt động');
            } elseif ($request->status === 'Không hoạt động') {
                $query->where(function ($q) {
                    $q->where('status', '!=', 'Hoạt động')->orWhereNull('status');
                });
            }
        }

        $products = $query->orderBy('created_at', 'desc')->get();
        $activeCount = Product::where('status', 'Hoạt động')->count();
        $deletedCount = Product::onlyTrashed()->count();

        return view('admin.products.index', compact('products', 'activeCount', 'deletedCount'));
    }
    public function show($id)
    {
        // Eager load cả quan hệ images để show ảnh
        $product = Product::with('images')->findOrFail($id);

        return view('admin.products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:125',
            'price' => 'required|numeric|min:0',
            'import_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'description_short' => 'required|string',
            'description_long' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'required|string',
            'is_featured' => 'boolean',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'brand_id.required' => 'Thương hiệu sản phẩm là bắt buộc.',
            'status.required' => 'Thương hiệu sản phẩm là bắt buộc.',
            'description_short.required' => 'Mô tả ngắn sản phẩm là bắt buộc.',
            'price.required' => 'Giá gốc là bắt buộc.',
            'import_price.required' => 'Giá nhập là bắt buộc.',
            'sale_price.required' => 'Giá bán là bắt buộc.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'brand_id.exists' => 'Thương hiệu không hợp lệ.',
        ]);

        Product::create($validated);

        return redirect()->route('admin.products.list')->with('success', 'Thêm sản phẩm thành công.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:125',
            'price' => 'required|numeric|min:0',
            'import_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'description_short' => 'required|string',
            'description_long' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'required|string',
            'is_featured' => 'boolean',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'brand_id.required' => 'Thương hiệu sản phẩm là bắt buộc.',
            'status.required' => 'Thương hiệu sản phẩm là bắt buộc.',
            'description_short.required' => 'Mô tả ngắn sản phẩm là bắt buộc.',
            'price.required' => 'Giá gốc là bắt buộc.',
            'import_price.required' => 'Giá nhập là bắt buộc.',
            'sale_price.required' => 'Giá bán là bắt buộc.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'brand_id.exists' => 'Thương hiệu không hợp lệ.',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()->route('admin.products.list')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.list')->with('success', 'Xóa mềm sản phẩm thành công.');
    }

    public function bin()
    {
        $products = Product::onlyTrashed()->orderBy('id')->paginate(10);
        return view('admin.products.bin', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.bin')->with('success', 'Khôi phục sản phẩm thành công.');
    }

    public function forceDelete($id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);
            $product->forceDelete();
            return redirect()->route('admin.products.bin')->with('success', 'Xóa vĩnh viễn sản phẩm thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không thể xóa vĩnh viễn sản phẩm.');
        }
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm để xóa.');
        }
        try {
            Product::whereIn('id', $ids)->delete();
            return redirect()->route('admin.products.list')->with('success', 'Đã xóa mềm các sản phẩm đã chọn!');
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
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm để khôi phục.');
        }
        try {
            Product::onlyTrashed()->whereIn('id', $ids)->restore();
            return redirect()->route('admin.products.bin')->with('success', 'Đã khôi phục các sản phẩm đã chọn!');
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
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm để xóa vĩnh viễn.');
        }
        try {
            Product::withTrashed()->whereIn('id', $ids)->forceDelete();
            return redirect()->route('admin.products.bin')->with('success', 'Đã xóa vĩnh viễn các sản phẩm đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn: ' . $e->getMessage());
        }
    }
}
