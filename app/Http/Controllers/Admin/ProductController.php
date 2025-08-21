<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Spherical;
use App\Models\Cylindrical;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Admin\NotificationController;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with(['categories', 'brand', 'variations']);

        if ($request->filled('search')) {
            $search = mb_strtolower(trim($request->search));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(description_short) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'Hoạt động') {
                $query->where('status', 'Hoạt động');
            } elseif ($request->status === 'Không hoạt động') {
                $query->where(function ($q) {
                    $q->where('status', '!=', 'Hoạt động')->orWhereNull('status');
                });
            }
        }

        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from)
                ->whereDate('created_at', '<=', now()->toDateString());
        }

        $products = $query->orderBy('created_at', 'desc')->get();

        foreach ($products as $product) {
            if ($product->product_type === 'variable') {
                $product->default_price = $product->variations->first()->price ?? 0;
                $product->default_sale_price = $product->variations->first()->sale_price ?? $product->default_price;
            } else {
                $product->default_price = $product->price ?? 0;
                $product->default_sale_price = $product->sale_price ?? $product->price ?? 0;
            }
        }

        $activeCount = Product::where('status', 'Hoạt động')->count();
        $deletedCount = Product::onlyTrashed()->count();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'activeCount', 'deletedCount', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['images', 'variations.color', 'variations.size', 'brand', 'categories', 'reviews', 'comments.user'])->findOrFail($id);

        if ($product->product_type === 'variable') {
            $product->default_price = $product->variations->first()->price ?? 0;
            $product->default_sale_price = $product->variations->first()->sale_price ?? $product->default_price;
        } else {
            $product->default_price = $product->price ?? 0;
            $product->default_sale_price = $product->sale_price ?? $product->price ?? 0;
        }

        return view('admin.products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::with('children')->get();
        $brands = Brand::all();
        $colors = Color::orderBy('sort_order')->get();
        $sizes = Size::orderBy('sort_order')->get();
        $sphericals = Spherical::orderBy('sort_order')->get();
        $cylindricals = Cylindrical::orderBy('sort_order')->get();
        return view('admin.products.create', compact('categories', 'brands', 'colors', 'sizes', 'sphericals', 'cylindricals'));
    }

    public function store(Request $request)
    {
        try {
            // Xử lý dữ liệu price, sale_price và quantity trước khi validate
            $processedData = $request->all();

            // Chỉ xử lý price, sale_price và quantity nếu product_type là simple
            if ($processedData['product_type'] === 'simple') {
                if (isset($processedData['price'])) {
                    $processedData['price'] = str_replace(',', '.', trim($processedData['price']));
                    if (empty($processedData['price']) || !is_numeric($processedData['price'])) {
                        $processedData['price'] = '0';
                    }
                }
                if (isset($processedData['sale_price'])) {
                    $processedData['sale_price'] = str_replace(',', '.', trim($processedData['sale_price']));
                    if (empty($processedData['sale_price']) || !is_numeric($processedData['sale_price'])) {
                        $processedData['sale_price'] = null;
                    }
                }
                if (isset($processedData['quantity'])) {
                    $processedData['quantity'] = (int)trim($processedData['quantity']);
                    if (!is_numeric($processedData['quantity']) || $processedData['quantity'] < 0) {
                        $processedData['quantity'] = 0;
                    }
                }
            } else {
                // Nếu product_type là variable, không cần price, sale_price, quantity
                unset($processedData['price']);
                unset($processedData['sale_price']);
                unset($processedData['quantity']);
            }

            // Xử lý price, sale_price và quantity cho biến thể
            if (isset($processedData['variations'])) {
                foreach ($processedData['variations'] as $index => &$variation) {
                    if (isset($variation['price'])) {
                        $variation['price'] = (int)str_replace(',', '.', trim($variation['price']));
                        if (empty($variation['price']) || !is_numeric($variation['price'])) {
                            $variation['price'] = 0;
                        }
                    }
                    if (isset($variation['sale_price'])) {
                        $variation['sale_price'] = (int)str_replace(',', '.', trim($variation['sale_price']));
                        if (empty($variation['sale_price']) || !is_numeric($variation['sale_price'])) {
                            $variation['sale_price'] = null;
                        }
                    }
                    if (isset($variation['quantity'])) {
                        $variation['quantity'] = (int)trim($variation['quantity']);
                        if (!is_numeric($variation['quantity']) || $variation['quantity'] < 0) {
                            $variation['quantity'] = 0;
                        }
                    }
                    // Đảm bảo name của biến thể không rỗng
                    $variation['name'] = !empty(trim($variation['name'] ?? '')) ? trim($variation['name']) : 'Biến thể ' . ($index + 1);
                }
                unset($variation);
            } else {
                if ($processedData['product_type'] === 'variable') {
                    // No variations provided for variable product
                }
            }

            $request->merge($processedData);

            // Quy tắc validate với thông báo lỗi bằng tiếng Việt
            $messages = [
                'name.required' => 'Tên sản phẩm là bắt buộc.',
                'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
                'name.max' => 'Tên sản phẩm không được vượt quá 125 ký tự.',
                'name.unique' => 'Tên sản phẩm đã tồn tại.',
                'description_short.required' => 'Mô tả ngắn là bắt buộc.',
                'description_short.string' => 'Mô tả ngắn phải là chuỗi ký tự.',
                'description_long.required' => 'Mô tả chi tiết là bắt buộc.',
                'description_long.string' => 'Mô tả chi tiết phải là chuỗi ký tự.',
                'categories.required' => 'Vui lòng chọn ít nhất một danh mục.',
                'categories.array' => 'Danh mục phải là một mảng.',
                'categories.*.exists' => 'Danh mục được chọn không hợp lệ.',
                'brand_id.required' => 'Vui lòng chọn một thương hiệu.',
                'brand_id.exists' => 'Thương hiệu được chọn không hợp lệ.',
                'product_type.required' => 'Loại sản phẩm là bắt buộc.',
                'product_type.in' => 'Loại sản phẩm phải là "Sản phẩm đơn giản" hoặc "Sản phẩm có biến thể".',
                'sku.required' => 'Mã sản phẩm là bắt buộc.',
                'sku.string' => 'Mã sản phẩm phải là chuỗi ký tự.',
                'sku.unique' => 'Mã sản phẩm đã tồn tại.',
                'slug.required' => 'Slug sản phẩm là bắt buộc.',
                'slug.string' => 'Slug sản phẩm phải là chuỗi ký tự.',
                'slug.unique' => 'Slug sản phẩm đã tồn tại.',
                'price.required_if' => 'Giá gốc là bắt buộc cho sản phẩm đơn giản.',
                'price.numeric' => 'Giá gốc phải là một số hợp lệ.',
                'price.min' => 'Giá gốc không được nhỏ hơn 0.',
                'sale_price.numeric' => 'Giá khuyến mãi phải là một số hợp lệ.',
                'sale_price.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
                'sale_price.lte' => 'Giá khuyến mãi không được lớn hơn giá gốc.',
                'quantity.required_if' => 'Số lượng là bắt buộc cho sản phẩm đơn giản.',
                'quantity.integer' => 'Số lượng phải là số nguyên.',
                'quantity.min' => 'Số lượng không được nhỏ hơn 0.',
                'variations.required_if' => 'Sản phẩm có biến thể phải có ít nhất một biến thể.',
                'variations.array' => 'Dữ liệu biến thể phải là một mảng.',
                'variations.min' => 'Phải có ít nhất một biến thể.',
                'variations.*.name.required' => 'Tên biến thể là bắt buộc.',
                'variations.*.name.string' => 'Tên biến thể phải là chuỗi ký tự.',
                'variations.*.sku.required' => 'Mã biến thể là bắt buộc.',
                'variations.*.sku.string' => 'Mã biến thể phải là chuỗi ký tự.',
                'variations.*.sku.unique' => 'Mã biến thể đã tồn tại.',
                'variations.*.price.required' => 'Giá biến thể là bắt buộc.',
                'variations.*.price.numeric' => 'Giá biến thể phải là một số hợp lệ.',
                'variations.*.price.min' => 'Giá biến thể không được nhỏ hơn 0.',
                'variations.*.sale_price.numeric' => 'Giá khuyến mãi của biến thể phải là một số hợp lệ.',
                'variations.*.sale_price.min' => 'Giá khuyến mãi của biến thể không được nhỏ hơn 0.',
                'variations.*.sale_price.lte' => 'Giá khuyến mãi của biến thể không được lớn hơn giá gốc.',
                'variations.*.quantity.required' => 'Số lượng biến thể là bắt buộc.',
                'variations.*.quantity.integer' => 'Số lượng biến thể phải là số nguyên.',
                'variations.*.quantity.min' => 'Số lượng biến thể không được nhỏ hơn 0.',
                'variations.*.image.image' => 'Ảnh biến thể phải là một tệp hình ảnh.',
                'variations.*.image.mimes' => 'Ảnh biến thể phải có định dạng jpg, jpeg, png, gif, webp hoặc tiff.',
                'variations.*.image.max' => 'Ảnh biến thể không được vượt quá 5MB.',
                'attributes.required_if' => 'Thuộc tính biến thể là bắt buộc đối với sản phẩm có biến thể.',
                'attributes.array' => 'Dữ liệu thuộc tính phải là một mảng.',
                'attributes.*.type.required_with' => 'Loại thuộc tính là bắt buộc.',
                'attributes.*.type.in' => 'Loại thuộc tính phải là "color", "size", "spherical" hoặc "cylindrical".',
                'attributes.*.values.required_with' => 'Giá trị thuộc tính là bắt buộc.',
                'attributes.*.values.array' => 'Giá trị thuộc tính phải là một mảng.',
                'featured_image.image' => 'Ảnh đại diện phải là file ảnh.',
                'featured_image.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, hoặc gif.',
                'featured_image.max' => 'Ảnh đại diện không được lớn hơn 2MB.',
                'gallery_images.*.image' => 'Album ảnh phải chứa các file ảnh.',
                'gallery_images.*.mimes' => 'Album ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
                'gallery_images.*.max' => 'Mỗi ảnh trong album không được lớn hơn 2MB.',
                'video_path.file' => 'Video sản phẩm phải là một tệp.',
                'video_path.mimes' => 'Video sản phẩm phải có định dạng mp4, webm hoặc ogg.',
                'video_path.max' => 'Video sản phẩm không được vượt quá 50MB.',
            ];

            $rules = [
                'name' => 'required|string|max:125|unique:products,name',
                'description_short' => 'required|string',
                'description_long' => 'required|string',
                'categories' => 'required|array',
                'categories.*' => 'exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
                'product_type' => 'required|in:simple,variable',
                'sku' => 'required|string|unique:products,sku',
                'slug' => 'required|string|unique:products,slug',
                'video_path' => 'nullable|file|mimes:mp4,webm,ogg|max:51200',
                'variations' => [
                    'required_if:product_type,variable',
                    'array',
                    'min:1',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('product_type') === 'variable' && empty($value)) {
                            $fail('Sản phẩm có biến thể phải có ít nhất một biến thể.');
                        }
                    },
                ],
                'variations.*.name' => 'required|string',
                'variations.*.sku' => 'required|string|unique:variations,sku',
                'variations.*.price' => 'required|numeric|min:0',
                'variations.*.sale_price' => 'nullable|numeric|min:0|lte:variations.*.price',
                'variations.*.quantity' => 'required|integer|min:0',
                'variations.*.image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120',
                'variations.*.color_id' => 'nullable|integer|exists:colors,id',
                'variations.*.size_id' => 'nullable|integer|exists:sizes,id',
                'variations.*.spherical_id' => 'nullable|integer|exists:sphericals,id',
                'variations.*.cylindrical_id' => 'nullable|integer|exists:cylindricals,id',
                'attributes' => 'required_if:product_type,variable|array',
                'attributes.*.type' => 'required_with:attributes|in:color,size,spherical,cylindrical',
                'attributes.*.values' => 'sometimes|array',
                'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120',
                'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120',
            ];

            // Chỉ thêm validate cho price, sale_price, quantity nếu product_type là simple
            if ($request->input('product_type') === 'simple') {
                $rules['price'] = 'required|numeric|min:0';
                $rules['sale_price'] = 'nullable|numeric|min:0|lte:price';
                $rules['quantity'] = 'required|integer|min:0';
            }

            $validated = $request->validate($rules, $messages);

            $errors = [];
            foreach ($request->input('attributes', []) as $index => $attribute) {
                if (empty($attribute['values']) || !is_array($attribute['values'])) {
                    continue;
                }
                foreach ($attribute['values'] as $valueIndex => $value) {
                    if ($attribute['type'] === 'color') {
                        $colorExists = Color::where('id', $value)->exists();
                        if (!$colorExists) {
                            $errorKey = "attributes.$index.values.$valueIndex";
                            $errors[$errorKey] = "Giá trị '$value' không tồn tại trong danh sách màu sắc.";
                        }
                    } elseif ($attribute['type'] === 'size') {
                        $sizeExists = Size::where('id', $value)->exists();
                        if (!$sizeExists) {
                            $errorKey = "attributes.$index.values.$valueIndex";
                            $errors[$errorKey] = "Giá trị '$value' không tồn tại trong danh sách kích thước.";
                        }
                    } elseif ($attribute['type'] === 'spherical') {
                        $sphericalExists = Spherical::where('id', $value)->exists();
                        if (!$sphericalExists) {
                            $errorKey = "attributes.$index.values.$valueIndex";
                            $errors[$errorKey] = "Giá trị '$value' không tồn tại trong danh sách độ cận.";
                        }
                    } elseif ($attribute['type'] === 'cylindrical') {
                        $cylindricalExists = Cylindrical::where('id', $value)->exists();
                        if (!$cylindricalExists) {
                            $errorKey = "attributes.$index.values.$valueIndex";
                            $errors[$errorKey] = "Giá trị '$value' không tồn tại trong danh sách độ loạn.";
                        }
                    }
                }
            }

            if (!empty($errors)) {
                return redirect()->back()->withErrors($errors)->withInput();
            }

            $product = new Product();
            $product->name = $validated['name'];
            $product->description_short = $validated['description_short'];
            $product->description_long = $validated['description_long'];
            $product->brand_id = $validated['brand_id'];
            $product->product_type = $validated['product_type'];
            $product->sku = $validated['sku'];
            $product->slug = $validated['slug'];
            $product->status = 'Hoạt động';
            $product->is_featured = 0;

            if ($validated['product_type'] === 'simple') {
                $product->price = (float)$validated['price'];
                $product->sale_price = isset($validated['sale_price']) && $validated['sale_price'] !== '' ? (float)$validated['sale_price'] : null;
                $product->quantity = (int)$validated['quantity'];
            }

            if ($request->hasFile('video_path')) {
                $video = $request->file('video_path');
                if ($video->isValid()) {
                    $path = $video->store('videos/products', 'public');
                    $product->video_path = $path;
                }
            }

            if (!$product->save()) {
                return redirect()->back()->with('error', 'Không thể lưu sản phẩm. Vui lòng thử lại.');
            }

            $product->categories()->sync($validated['categories']);

            if ($request->hasFile('featured_image')) {
                $featuredImage = $request->file('featured_image');
                if ($featuredImage->isValid()) {
                    $path = $featuredImage->store('images/products', 'public');
                    if ($path) {
                        $product->images()->create(['image_path' => $path, 'is_featured' => true]);
                    }
                }
            }

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('images/products', 'public');
                        if ($path) {
                            $product->images()->create(['image_path' => $path, 'is_featured' => false]);
                        }
                    }
                }
            }

            if ($validated['product_type'] === 'variable' && !empty($validated['variations'])) {
                foreach ($validated['variations'] as $index => $variationData) {
                    $variation = new Variation([
                        'product_id' => $product->id,
                        'name' => !empty(trim($variationData['name'] ?? '')) ? trim($variationData['name']) : 'Biến thể ' . ($index + 1),
                        'sku' => $variationData['sku'],
                        'price' => (float)$variationData['price'],
                        'sale_price' => isset($variationData['sale_price']) ? (float)$variationData['sale_price'] : null,
                        'quantity' => (int)$variationData['quantity'],
                        'color_id' => $variationData['color_id'] ?? null,
                        'size_id' => $variationData['size_id'] ?? null,
                        'spherical_id' => $variationData['spherical_id'] ?? null,
                        'cylindrical_id' => $variationData['cylindrical_id'] ?? null,
                    ]);
                    $variation->save();
                    if (isset($variationData['image']) && $request->hasFile("variations.$index.image")) {
                        $image = $request->file("variations.$index.image");
                        if ($image->isValid()) {
                            $path = $image->store('variations', 'public');
                            $variation->images()->create(['image_path' => $path]);
                        }
                    }
                }
            }

            // Gửi thông báo khi tạo sản phẩm mới
            app(NotificationController::class)->notifyNewProduct($product);

            return redirect()->route('admin.products.list')->with('success', 'Sản phẩm đã được thêm thành công!');
        }
         catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'variations.color', 'variations.size', 'variations.spherical', 'variations.cylindrical', 'variations.images', 'categories', 'brand'])->findOrFail($id);
        $categories = Category::with('children')->get();
        $brands = Brand::all();
        $colors = Color::orderBy('sort_order')->get();
        $sizes = Size::orderBy('sort_order')->get();
        $sphericals = Spherical::orderBy('sort_order')->get();
        $cylindricals = Cylindrical::orderBy('sort_order')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'colors', 'sizes', 'sphericals', 'cylindricals'));
    }

   public function update(Request $request, $id)
{
    try {
        $product = Product::with(['images', 'variations'])->findOrFail($id);

        // Xử lý dữ liệu trước khi validate
        $processedData = $request->all();

        // Chỉ xử lý price, sale_price và quantity nếu product_type là simple
        if ($product->product_type === 'simple') {
            if (isset($processedData['price'])) {
                $processedData['price'] = str_replace(',', '.', trim($processedData['price']));
                if (empty($processedData['price']) || !is_numeric($processedData['price'])) {
                    $processedData['price'] = $product->price;
                }
            }
            if (isset($processedData['sale_price'])) {
                $processedData['sale_price'] = str_replace(',', '.', trim($processedData['sale_price']));
                if (empty($processedData['sale_price']) || !is_numeric($processedData['sale_price'])) {
                    $processedData['sale_price'] = $product->sale_price;
                }
            }
            if (isset($processedData['quantity'])) {
                $processedData['quantity'] = (int)trim($processedData['quantity']);
                if (!is_numeric($processedData['quantity']) || $processedData['quantity'] < 0) {
                    $processedData['quantity'] = $product->quantity;
                }
            }
        } else {
            unset($processedData['price']);
            unset($processedData['sale_price']);
            unset($processedData['quantity']);
        }

        // Xử lý variations
        if ($product->product_type === 'variable' && isset($processedData['variations'])) {
            foreach ($processedData['variations'] as $index => &$variation) {
                $existingVariation = isset($variation['id']) ? Variation::find($variation['id']) : null;

                if (isset($variation['price'])) {
                    $variation['price'] = (float)str_replace(',', '.', trim($variation['price']));
                    if (empty($variation['price']) || !is_numeric($variation['price'])) {
                        $variation['price'] = $existingVariation ? $existingVariation->price : 0;
                    }
                }
                if (isset($variation['sale_price'])) {
                    $variation['sale_price'] = (float)str_replace(',', '.', trim($variation['sale_price']));
                    if (empty($variation['sale_price']) || !is_numeric($variation['sale_price'])) {
                        $variation['sale_price'] = $existingVariation ? $existingVariation->sale_price : null;
                    }
                }
                if (isset($variation['quantity'])) {
                    $variation['quantity'] = (int)trim($variation['quantity']);
                    if (!is_numeric($variation['quantity']) || $variation['quantity'] < 0) {
                        $variation['quantity'] = $existingVariation ? $existingVariation->quantity : 0;
                    }
                }
                $variation['name'] = !empty(trim($variation['name'] ?? '')) ? trim($variation['name']) : 'Biến thể ' . ($index + 1);
            }
            unset($variation);
        }

        $request->merge($processedData);

        // Quy tắc validate
        $messages = [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
            'sku.unique' => 'Mã sản phẩm đã tồn tại.',
            'slug.unique' => 'Slug đã tồn tại.',
            'variations.*.sku.unique' => 'Mã biến thể đã tồn tại.',
            'variations.*.price.required' => 'Giá biến thể là bắt buộc.',
            'variations.*.quantity.required' => 'Số lượng biến thể là bắt buộc.',
            'attributes.*.type.required' => 'Loại thuộc tính là bắt buộc.',
            'attributes.*.values.required' => 'Giá trị thuộc tính là bắt buộc.',
        ];

        $rules = [
            'name' => 'required|string|max:125|unique:products,name,' . $id,
            'description_short' => 'nullable|string',
            'description_long' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'sku' => 'nullable|string|unique:products,sku,' . $id,
            'slug' => 'nullable|string|unique:products,slug,' . $id,
            'status' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'video_path' => 'nullable|file|mimes:mp4,webm,ogg|max:51200',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120',
        ];

        if ($product->product_type === 'simple') {
            $rules['price'] = 'nullable|numeric|min:0';
            $rules['sale_price'] = 'nullable|numeric|min:0|lte:price';
            $rules['quantity'] = 'required|integer|min:0';
        } elseif ($product->product_type === 'variable') {
            $rules['variations'] = 'required|array|min:1';
            $rules['variations.*.id'] = 'nullable|exists:variations,id';
            $rules['variations.*.name'] = 'required|string';
            $rules['variations.*.sku'] = [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request, $id) {
                    $index = explode('.', $attribute)[1];
                    $variationId = $request->input("variations.$index.id");
                    $exists = Variation::where('sku', $value)
                        ->where('product_id', $id)
                        ->where('id', '!=', $variationId)
                        ->exists();
                    if ($exists) {
                        $fail("Mã biến thể '$value' đã tồn tại.");
                    }
                },
            ];
            $rules['variations.*.price'] = 'required|numeric|min:0';
            $rules['variations.*.sale_price'] = 'nullable|numeric|min:0|lte:variations.*.price';
            $rules['variations.*.quantity'] = 'required|integer|min:0';
            $rules['variations.*.image'] = 'nullable|image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120';
            $rules['variations.*.color_id'] = 'nullable|integer|exists:colors,id';
            $rules['variations.*.size_id'] = 'nullable|integer|exists:sizes,id';
            $rules['variations.*.spherical_id'] = 'nullable|integer|exists:sphericals,id';
            $rules['variations.*.cylindrical_id'] = 'nullable|integer|exists:cylindricals,id';
            // Chỉ validate attributes nếu được gửi và không ở edit mode
            if (!$request->has('_method') || $request->input('_method') !== 'PUT') {
                $rules['attributes'] = 'nullable|array';
                $rules['attributes.*.type'] = 'required_with:attributes|in:color,size,spherical,cylindrical';
                $rules['attributes.*.values'] = 'required_with:attributes.*.type|array';
            }
        }

        $validated = $request->validate($rules, $messages);

        // Validate giá trị thuộc tính (chỉ nếu attributes được gửi)
        $errors = [];
        if ($request->has('attributes') && $product->product_type === 'variable' && $request->input('_method') !== 'PUT') {
            foreach ($request->input('attributes', []) as $index => $attribute) {
                if (empty($attribute['values']) || !is_array($attribute['values'])) {
                    continue;
                }
                foreach ($attribute['values'] as $valueIndex => $value) {
                    if ($attribute['type'] === 'color') {
                        $colorExists = Color::where('id', $value)->exists();
                        if (!$colorExists) {
                            $errors["attributes.$index.values.$valueIndex"] = "Giá trị '$value' không tồn tại trong danh sách màu sắc.";
                        }
                    } elseif ($attribute['type'] === 'size') {
                        $sizeExists = Size::where('id', $value)->exists();
                        if (!$sizeExists) {
                            $errors["attributes.$index.values.$valueIndex"] = "Giá trị '$value' không tồn tại trong danh sách kích thước.";
                        }
                    } elseif ($attribute['type'] === 'spherical') {
                        $sphericalExists = Spherical::where('id', $value)->exists();
                        if (!$sphericalExists) {
                            $errors["attributes.$index.values.$valueIndex"] = "Giá trị '$value' không tồn tại trong danh sách độ cận.";
                        }
                    } elseif ($attribute['type'] === 'cylindrical') {
                        $cylindricalExists = Cylindrical::where('id', $value)->exists();
                        if (!$cylindricalExists) {
                            $errors["attributes.$index.values.$valueIndex"] = "Giá trị '$value' không tồn tại trong danh sách độ loạn.";
                        }
                    }
                }
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Cập nhật thông tin sản phẩm
        $updateData = $validated;
         {
            $updateData['price'] = isset($validated['price']) ? (float)$validated['price'] : $product->price;
            $updateData['sale_price'] = isset($validated['sale_price']) && $validated['sale_price'] !== '' ? (float)$validated['sale_price'] : $product->sale_price;
            $updateData['quantity'] = isset($validated['quantity']) ? (int)$validated['quantity'] : $product->quantity;
        }
        $product->update($updateData);

        // Xử lý video
        if ($request->hasFile('video_path')) {
            $video = $request->file('video_path');
            if ($video->isValid()) {
                if ($product->video_path) {
                    Storage::disk('public')->delete($product->video_path);
                }
                $path = $video->store('videos/products', 'public');
                $product->video_path = $path;
                $product->save();
            }
        }

        // Xử lý ảnh đại diện
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image');
            if ($featuredImage->isValid()) {
                $oldFeaturedImages = $product->images()->where('is_featured', true)->get();
                foreach ($oldFeaturedImages as $oldFeaturedImage) {
                    if (Storage::disk('public')->exists($oldFeaturedImage->image_path)) {
                        Storage::disk('public')->delete($oldFeaturedImage->image_path);
                    }
                    $oldFeaturedImage->delete();
                }
                $path = $featuredImage->store('images/products', 'public');
                $product->images()->create(['image_path' => $path, 'is_featured' => true]);
            }
        }

        // Xử lý ảnh bổ sung
        if ($request->hasFile('gallery_images')) {
            $product->images()->where('is_featured', false)->get()->each(function ($img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
                $img->delete();
            });
            foreach ($request->file('gallery_images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('images/products', 'public');
                    $product->images()->create(['image_path' => $path, 'is_featured' => false]);
                }
            }
        }

        // Cập nhật danh mục
        if ($request->has('categories')) {
            $product->categories()->sync($validated['categories']);
        }

        // Cập nhật biến thể
        if ($product->product_type === 'variable' && !empty($validated['variations'])) {
            $existingVariationIds = [];

            foreach ($validated['variations'] as $index => $variationData) {
                $colorId = isset($variationData['color_id']) && !empty($variationData['color_id']) ? $variationData['color_id'] : null;
                $sizeId = isset($variationData['size_id']) && !empty($variationData['size_id']) ? $variationData['size_id'] : null;
                $sphericalId = isset($variationData['spherical_id']) && !empty($variationData['spherical_id']) ? $variationData['spherical_id'] : null;
                $cylindricalId = isset($variationData['cylindrical_id']) && !empty($variationData['cylindrical_id']) ? $variationData['cylindrical_id'] : null;

                if (!empty($variationData['id'])) {
                    $variation = Variation::where('id', $variationData['id'])->where('product_id', $product->id)->first();
                    if ($variation) {
                        $updateData = [
                            'name' => $variationData['name'],
                            'sku' => $variationData['sku'],
                            'price' => (float)$variationData['price'],
                            'sale_price' => isset($variationData['sale_price']) ? (float)$variationData['sale_price'] : null,
                            'quantity' => (int)$variationData['quantity'],
                            'color_id' => $colorId,
                            'size_id' => $sizeId,
                            'spherical_id' => $sphericalId,
                            'cylindrical_id' => $cylindricalId,
                        ];
                        $variation->update($updateData);
                        $existingVariationIds[] = $variation->id;

                        if (isset($variationData['image']) && $request->hasFile("variations.$index.image")) {
                            $image = $request->file("variations.$index.image");
                            if ($image->isValid()) {
                                foreach ($variation->images as $oldImage) {
                                    if (Storage::disk('public')->exists($oldImage->image_path)) {
                                        Storage::disk('public')->delete($oldImage->image_path);
                                    }
                                    $oldImage->delete();
                                }
                                $path = $image->store('variations', 'public');
                                $variation->images()->create(['image_path' => $path]);
                            }
                        }
                    }
                } else {
                    $variation = new Variation([
                        'product_id' => $product->id,
                        'name' => $variationData['name'],
                        'sku' => $variationData['sku'],
                        'price' => (float)$variationData['price'],
                        'sale_price' => isset($variationData['sale_price']) ? (float)$variationData['sale_price'] : null,
                        'quantity' => (int)$variationData['quantity'],
                        'color_id' => $colorId,
                        'size_id' => $sizeId,
                        'spherical_id' => $sphericalId,
                        'cylindrical_id' => $cylindricalId,
                    ]);
                    $variation->save();
                    $existingVariationIds[] = $variation->id;

                    if (isset($variationData['image']) && $request->hasFile("variations.$index.image")) {
                        $image = $request->file("variations.$index.image");
                        if ($image->isValid()) {
                            $path = $image->store('variations', 'public');
                            $variation->images()->create(['image_path' => $path]);
                        }
                    }
                }
            }

            // Xóa biến thể không còn phù hợp
            $product->variations()->whereNotIn('id', $existingVariationIds)->each(function ($variation) {
                foreach ($variation->images as $image) {
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    $image->delete();
                }
                $variation->delete();
            });
        }

        return redirect()->route('admin.products.list')
            ->with('success', 'Cập nhật sản phẩm thành công.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())->withInput();
    }
}

    public function destroy($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $orderCount = $product->orderItems()->count();

        if ($orderCount > 0 && !$request->input('force')) {
            $message = "Sản phẩm này đã có trong {$orderCount} đơn hàng. Bạn có chắc chắn muốn xoá sản phẩm này?";
            return response()->json([
                'success' => false,
                'message' => $message,
                'orderCount' => $orderCount
            ]);
        }

        try {
            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được chuyển vào thùng rác'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa sản phẩm'
            ], 500);
        }
    }

    public function trashed(Request $request)
    {
        $query = Product::onlyTrashed()->with(['categories', 'brand', 'variations']);

        if ($request->filled('search')) {
            $search = mb_strtolower(trim($request->search));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(description_short) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('CAST(id AS CHAR) LIKE ?', ["%{$search}%"])
                    ->orWhereHas('categories', function ($subQ) use ($search) {
                        $subQ->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                    })
                    ->orWhereHas('brand', function ($subQ) use ($search) {
                        $subQ->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                    });
            });
        }

        $products = $query->orderBy('deleted_at', 'desc')->paginate(10);

        foreach ($products as $product) {
            if ($product->product_type === 'variable') {
                $product->default_price = $product->variations->first()->price ?? 0;
                $product->default_sale_price = $product->variations->first()->sale_price ?? $product->default_price;
            } else {
                $product->default_price = $product->price ?? 0;
                $product->default_sale_price = $product->sale_price ?? $product->price ?? 0;
            }
        }

        $activeCount = Product::where('status', 'Hoạt động')->count();
        $deletedCount = Product::onlyTrashed()->count();

        return view('admin.products.trashed', compact('products', 'activeCount', 'deletedCount'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.trashed')
            ->with('success', 'Khôi phục sản phẩm thành công.');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        $orderCount = $product->orderItems()->count();
        if ($orderCount > 0) {
            return redirect()->route('admin.products.trashed')
                ->with('error', 'Không thể xóa vĩnh viễn sản phẩm đã có trong ' . $orderCount . ' đơn hàng!');
        }

        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        foreach ($product->variations as $variation) {
            foreach ($variation->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }
            $variation->delete();
        }

        $product->forceDelete();

        return redirect()->route('admin.products.trashed')
            ->with('success', 'Xóa vĩnh viễn sản phẩm thành công.');
    }

    public function showBySlug($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['images', 'variations.color', 'variations.size', 'brand', 'categories', 'reviews'])
            ->firstOrFail();

        if ($product->product_type === 'variable') {
            $product->default_price = $product->variations->first()->price ?? 0;
            $product->default_sale_price = $product->variations->first()->sale_price ?? $product->default_price;
        } else {
            $product->default_price = $product->price ?? 0;
            $product->default_sale_price = $product->sale_price ?? $product->price ?? 0;
        }

        return view('admin.products.show', compact('product'));
    }
}
