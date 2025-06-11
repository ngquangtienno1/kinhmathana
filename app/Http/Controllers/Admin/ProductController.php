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
use App\Http\Controllers\Admin\NotificationController;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with(['categories', 'brand', 'variations']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description_short', 'like', "%{$search}%");
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
                $product->total_stock = $product->variations->sum('stock_quantity');
                $product->default_price = $product->variations->first()->price ?? 0;
                $product->default_sale_price = $product->variations->first()->sale_price ?? $product->default_price;
            } else {
                $product->total_stock = $product->stock_quantity ?? 0;
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
        $product = Product::with(['images', 'variations.color', 'variations.size', 'brand', 'categories', 'reviews'])->findOrFail($id);

        if ($product->product_type === 'variable') {
            $product->total_stock = $product->variations->sum('stock_quantity');
            $product->default_price = $product->variations->first()->price ?? 0;
            $product->default_sale_price = $product->variations->first()->sale_price ?? $product->default_price;
        } else {
            $product->total_stock = $product->stock_quantity ?? 0;
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
        \Log::info('Request data before validation', $request->all());

        try {
            // Xử lý dữ liệu price và sale_price trước khi validate
            $processedData = $request->all();

            // Chỉ xử lý price và sale_price nếu product_type là simple
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
                // Xử lý stock_quantity cho sản phẩm đơn giản
                if (isset($processedData['stock_quantity'])) {
                    $processedData['stock_quantity'] = (int)($processedData['stock_quantity'] ?? 0);
                } else {
                    $processedData['stock_quantity'] = 0;
                }
            } else {
                // Nếu product_type là variable, không cần price, sale_price, stock_quantity
                unset($processedData['price']);
                unset($processedData['sale_price']);
                unset($processedData['stock_quantity']);
            }

            // Xử lý price, sale_price, stock_quantity cho biến thể
            if (isset($processedData['variations'])) {
                foreach ($processedData['variations'] as $index => &$variation) {
                    if (isset($variation['price'])) {
                        $variation['price'] = str_replace(',', '.', trim($variation['price']));
                        if (empty($variation['price']) || !is_numeric($variation['price'])) {
                            $variation['price'] = '0';
                        }
                    }
                    if (isset($variation['sale_price'])) {
                        $variation['sale_price'] = str_replace(',', '.', trim($variation['sale_price']));
                        if (empty($variation['sale_price']) || !is_numeric($variation['sale_price'])) {
                            $variation['sale_price'] = null;
                        }
                    }
                    $variation['stock_quantity'] = (int)($variation['stock_quantity'] ?? 0);
                    // Đảm bảo name của biến thể không rỗng
                    $variation['name'] = !empty(trim($variation['name'] ?? '')) ? trim($variation['name']) : 'Biến thể ' . ($index + 1);
                    \Log::info("Variation name for index {$index}: {$variation['name']}");
                }
                unset($variation);
            } else {
                if ($processedData['product_type'] === 'variable') {
                    \Log::error('No variations provided for variable product', ['request_data' => $request->all()]);
                }
            }

            $request->merge($processedData);

            // Quy tắc validate với thông báo lỗi bằng tiếng Việt
            $messages = [
                'name.required' => 'Tên sản phẩm là bắt buộc.',
                'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
                'name.max' => 'Tên sản phẩm không được vượt quá 125 ký tự.',
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
                'stock_quantity.required_if' => 'Số lượng tồn kho là bắt buộc cho sản phẩm đơn giản.',
                'stock_quantity.integer' => 'Số lượng tồn kho phải là số nguyên.',
                'stock_quantity.min' => 'Số lượng tồn kho không được nhỏ hơn 0.',
                'price.required_if' => 'Giá gốc là bắt buộc cho sản phẩm đơn giản.',
                'price.numeric' => 'Giá gốc phải là một số hợp lệ.',
                'price.min' => 'Giá gốc không được nhỏ hơn 0.',
                'sale_price.numeric' => 'Giá khuyến mãi phải là một số hợp lệ.',
                'sale_price.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
                'sale_price.lte' => 'Giá khuyến mãi không được lớn hơn giá gốc.',
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
                'variations.*.stock_quantity.required' => 'Số lượng tồn kho của biến thể là bắt buộc.',
                'variations.*.stock_quantity.integer' => 'Số lượng tồn kho của biến thể phải là số nguyên.',
                'variations.*.stock_quantity.min' => 'Số lượng tồn kho của biến thể không được nhỏ hơn 0.',
                'variations.*.status.in' => 'Trạng thái biến thể không hợp lệ.',
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
                'name' => 'required|string|max:125',
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
                'variations.*.stock_quantity' => 'required|integer|min:0',
                'variations.*.status' => 'nullable|in:in_stock,out_of_stock,hidden',
                'variations.*.image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120',
                'attributes' => 'required_if:product_type,variable|array',
                'attributes.*.type' => 'required_with:attributes|in:color,size,spherical,cylindrical',
                'attributes.*.values' => 'required_with:attributes|array',
                'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120',
                'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120',
            ];

            // Chỉ thêm validate cho price, sale_price và stock_quantity nếu product_type là simple
            if ($request->input('product_type') === 'simple') {
                $rules['price'] = 'required|numeric|min:0';
                $rules['sale_price'] = 'nullable|numeric|min:0|lte:price';
                $rules['stock_quantity'] = 'required|integer|min:0';
            }

            $validated = $request->validate($rules, $messages);

            \Log::info('Validated data', ['validated' => $validated]);

            $errors = [];
            foreach ($request->input('attributes', []) as $index => $attribute) {
                if (!empty($attribute['values'])) {
                    foreach ($attribute['values'] as $valueIndex => $value) {
                        if ($attribute['type'] === 'color') {
                            $colorExists = Color::where('name', $value)->exists();
                            if (!$colorExists) {
                                $errorKey = "attributes.$index.values.$valueIndex";
                                $errors[$errorKey] = "Giá trị '$value' không tồn tại trong danh sách màu sắc.";
                            }
                        } elseif ($attribute['type'] === 'size') {
                            $sizeExists = Size::where('name', $value)->exists();
                            if (!$sizeExists) {
                                $errorKey = "attributes.$index.values.$valueIndex";
                                $errors[$errorKey] = "Giá trị '$value' không tồn tại trong danh sách kích thước.";
                            }
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
                $product->stock_quantity = (int)($validated['stock_quantity'] ?? 0);
                $product->price = (float)$validated['price'];
                $product->sale_price = isset($validated['sale_price']) && $validated['sale_price'] !== '' ? (float)$validated['sale_price'] : null;
            } else {
                $product->stock_quantity = 0; // Sẽ được tính lại sau khi tạo biến thể
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
                    $colorId = null;
                    $sizeId = null;
                    $spherical = null;
                    $cylindrical = null;

                    // Parse variation name to extract attributes
                    $attributes = array_map('trim', explode('-', $variationData['name']));
                    foreach ($validated['attributes'] as $attribute) {
                        foreach ($attribute['values'] as $value) {
                            if (in_array($value, $attributes)) {
                                if ($attribute['type'] === 'color') {
                                    $color = Color::where('name', $value)->first();
                                    if ($color) {
                                        $colorId = $color->id;
                                    }
                                } elseif ($attribute['type'] === 'size') {
                                    $size = Size::where('name', $value)->first();
                                    if ($size) {
                                        $sizeId = $size->id;
                                    }
                                } elseif ($attribute['type'] === 'spherical') {
                                    $spherical = Spherical::where('value', (float)$value)->first();
                                    if ($spherical) {
                                        $sphericalId = $spherical->id;
                                    }
                                } elseif ($attribute['type'] === 'cylindrical') {
                                    $cylindrical = Cylindrical::where('value', (float)$value)->first();
                                    if ($cylindrical) {
                                        $cylindricalId = $cylindrical->id;
                                    }
                                }
                            }
                        }
                    }

                    $variation = new Variation([
                        'product_id' => $product->id,
                        'name' => !empty(trim($variationData['name'] ?? '')) ? trim($variationData['name']) : 'Biến thể ' . ($index + 1),
                        'sku' => $variationData['sku'],
                        'price' => (float)$variationData['price'],
                        'sale_price' => isset($variationData['sale_price']) ? (float)$variationData['sale_price'] : null,
                        'stock_quantity' => (int)$variationData['stock_quantity'],
                        'status' => $variationData['status'] ?? 'in_stock',
                        'color_id' => $colorId,
                        'size_id' => $sizeId,
                        'spherical_id' => $sphericalId ?? null,
                        'cylindrical_id' => $cylindricalId ?? null,
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
                // Tính lại stock_quantity dựa trên tổng các biến thể
                $product->stock_quantity = $product->variations->sum('stock_quantity');
                $product->save();
            }

            \Log::info('Product created', ['id' => $product->id, 'stock_quantity' => $product->stock_quantity]);

            // Gửi thông báo khi tạo sản phẩm mới
            app(NotificationController::class)->notifyNewProduct($product);

            return redirect()->route('admin.products.list')->with('success', 'Sản phẩm đã được thêm thành công!');
        } catch (\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->validator->errors()->all(), 'request_data' => $request->all()]);
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error occurred while storing product', ['message' => $e->getMessage(), 'request_data' => $request->all()]);
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

        if ($product->product_type === 'variable') {
            $product->total_stock = $product->variations->sum('stock_quantity');
        } else {
            $product->total_stock = $product->stock_quantity ?? 0;
        }

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'colors', 'sizes', 'sphericals', 'cylindricals'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        \Log::info('Request data before validation (update)', [
        'all' => $request->all(),
        'variations' => $request->input('variations', []),
        'attributes' => $request->input('attributes', []),
    ]);

        // Xử lý dữ liệu trước khi validate
        $processedData = $request->all();

        if ($product->product_type === 'simple') {
            // Xử lý stock_quantity cho sản phẩm đơn giản
            if (isset($processedData['stock_quantity'])) {
                $processedData['stock_quantity'] = (int)($processedData['stock_quantity'] ?? 0);
            } else {
                $processedData['stock_quantity'] = 0;
            }
            // Xử lý price và sale_price
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
        } else {
            // Nếu product_type là variable, không cần price, sale_price, stock_quantity
            unset($processedData['price']);
            unset($processedData['sale_price']);
            unset($processedData['stock_quantity']);
        }

        // Xử lý variations nếu có
        if (isset($processedData['variations'])) {
            foreach ($processedData['variations'] as $index => &$variation) {
                if (isset($variation['price'])) {
                    $variation['price'] = str_replace(',', '.', trim($variation['price']));
                    if (empty($variation['price']) || !is_numeric($variation['price'])) {
                        $variation['price'] = '0';
                    }
                }
                if (isset($variation['sale_price'])) {
                    $variation['sale_price'] = str_replace(',', '.', trim($variation['sale_price']));
                    if (empty($variation['sale_price']) || !is_numeric($variation['sale_price'])) {
                        $variation['sale_price'] = null;
                    }
                }
                $variation['stock_quantity'] = (int)($variation['stock_quantity'] ?? 0);
                $variation['name'] = !empty(trim($variation['name'] ?? '')) ? trim($variation['name']) : 'Biến thể ' . ($index + 1);
            }
            unset($variation);
        }

        $request->merge($processedData);

        // Quy tắc validate với thông báo lỗi bằng tiếng Việt
        $messages = [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
            'name.max' => 'Tên sản phẩm không được vượt quá 125 ký tự.',
            'description_short.required' => 'Mô tả ngắn là bắt buộc.',
            'description_short.string' => 'Mô tả ngắn phải là chuỗi ký tự.',
            'description_long.string' => 'Mô tả chi tiết phải là chuỗi ký tự.',
            'categories.required' => 'Vui lòng chọn ít nhất một danh mục.',
            'categories.array' => 'Danh mục phải là một mảng.',
            'categories.*.exists' => 'Danh mục được chọn không hợp lệ.',
            'brand_id.required' => 'Vui lòng chọn một thương hiệu.',
            'brand_id.exists' => 'Thương hiệu được chọn không hợp lệ.',
            'status.required' => 'Trạng thái sản phẩm là bắt buộc.',
            'status.string' => 'Trạng thái sản phẩm phải là chuỗi ký tự.',
            'is_featured.required' => 'Trạng thái nổi bật là bắt buộc.',
            'is_featured.boolean' => 'Trạng thái nổi bật phải là true hoặc false.',
            'stock_quantity.required' => 'Số lượng tồn kho là bắt buộc.',
            'stock_quantity.integer' => 'Số lượng tồn kho phải là số nguyên.',
            'stock_quantity.min' => 'Số lượng tồn kho không được nhỏ hơn 0.',
            'price.required' => 'Giá gốc là bắt buộc đối với sản phẩm đơn giản.',
            'price.numeric' => 'Giá gốc phải là một số hợp lệ.',
            'price.min' => 'Giá gốc không được nhỏ hơn 0.',
            'sale_price.numeric' => 'Giá khuyến mãi phải là một số hợp lệ.',
            'sale_price.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
            'variations.array' => 'Dữ liệu biến thể phải là một mảng.',
            'variations.*.id.exists' => 'ID biến thể không hợp lệ.',
            'variations.*.name.required' => 'Tên biến thể là bắt buộc.',
            'variations.*.name.string' => 'Tên biến thể phải là chuỗi ký tự.',
            'variations.*.price.numeric' => 'Giá biến thể phải là số hợp lệ.',
            'variations.*.price.min' => 'Giá biến thể không được nhỏ hơn 0.',
            'variations.*.sale_price.numeric' => 'Giá khuyến mãi của biến thể phải là số hợp lệ.',
            'variations.*.sale_price.min' => 'Giá khuyến mãi của biến thể không được nhỏ hơn 0.',
            'variations.*.stock_quantity.required' => 'Số lượng tồn kho của biến thể là bắt buộc.',
            'variations.*.stock_quantity.integer' => 'Số lượng tồn kho của biến thể phải là số nguyên.',
            'variations.*.stock_quantity.min' => 'Số lượng tồn kho của biến thể không được nhỏ hơn 0.',
            'variations.*.status.in' => 'Trạng thái biến thể không hợp lệ.',
            'variations.*.image.image' => 'Ảnh biến thể phải là một tệp hình ảnh.',
            'variations.*.image.mimes' => 'Ảnh biến thể phải có định dạng jpg, jpeg, png, gif, webp hoặc tiff.',
            'variations.*.image.max' => 'Ảnh biến thể không được vượt quá 5MB.',
            'featured_image.image' => 'Ảnh đại diện phải là một tệp hình ảnh.',
            'featured_image.mimes' => 'Ảnh đại diện phải có định dạng jpg, jpeg, png, gif, webp hoặc tiff.',
            'featured_image.max' => 'Ảnh đại diện không được vượt quá 5MB.',
            'gallery_images.array' => 'Ảnh thư viện phải là một mảng.',
            'gallery_images.*.image' => 'Ảnh trong thư viện phải là một tệp hình ảnh.',
            'gallery_images.*.mimes' => 'Ảnh trong ảnh thư viện phải có định dạng jpg, jpeg, png, gif, webp hoặc tiff.',
            'gallery_images.*.max' => 'Ảnh trong thư viện không được vượt quá 5MB.',
            'video_path.file' => 'Video sản phẩm phải là một tệp.',
            'video_path.mimes' => 'Video sản phẩm phải có định dạng mp4, webm hoặc ogg.',
            'video_path.max' => 'Video sản phẩm không được vượt quá 50MB.',
        ];

        $rules = [
    'name' => 'required|string|max:125',
    'description_short' => 'required|string',
    'description_long' => 'nullable|string',
    'categories' => 'required|array',
    'categories.*' => 'exists:categories,id',
    'brand_id' => 'required|exists:brands,id',
    'status' => 'required|string',
    'is_featured' => 'required|boolean',
    'variations' => [
        'required_if:product_type,variable',
        'array',
        'min:1',
        function ($attribute, $value, $fail) use ($product) {
            if ($product->product_type === 'variable' && empty($value)) {
                $fail('Sản phẩm có biến thể phải có ít nhất một biến thể.');
            }
        },
    ],
    'variations.*.id' => 'nullable|exists:variations,id',
    'variations.*.name' => 'required|string',
    'variations.*.sku' => [
    'required',
    'string',
    function ($attribute, $value, $fail) use ($request) {
        $index = explode('.', $attribute)[1]; // Lấy index từ variations.X.sku
        $variationId = $request->input("variations.$index.id", null);
        $exists = Variation::where('sku', $value)
            ->where('id', '!=', $variationId)
            ->exists();
        if ($exists) {
            $fail("Mã biến thể '$value' đã tồn tại.");
        }
    },
],
    'variations.*.price' => 'required|numeric|min:0',
    'variations.*.sale_price' => 'nullable|numeric|min:0|lte:variations.*.price',
    'variations.*.stock_quantity' => 'required|integer|min:0',
    'variations.*.status' => 'nullable|in:in_stock,out_of_stock,hidden',
    'variations.*.image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120',
    'attributes' => 'required_if:product_type,variable|array',
    'attributes.*.type' => 'required_with:attributes|in:color,size,spherical,cylindrical',
    'attributes.*.values' => 'required_with:attributes|array',
    'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120',
    'gallery_images' => 'nullable|array',
    'gallery_images.*' => 'image|mimes:jpg,jpeg,png,gif,webp,tiff|max:5120',
    'video_path' => 'nullable|file|mimes:mp4,webm,ogg|max:51200',
];

if ($product->product_type === 'simple') {
    $rules['stock_quantity'] = 'required|integer|min:0';
    $rules['price'] = 'required|numeric|min:0';
    $rules['sale_price'] = 'nullable|numeric|min:0|lte:price';
}

        $validated = $request->validate($rules, $messages);

        // Xử lý dữ liệu variations trước khi lưu
        $processedVariations = $validated['variations'] ?? [];
        foreach ($processedVariations as $index => &$variation) {
            // Đảm bảo name không rỗng
            $variation['name'] = !empty(trim($variation['name'] ?? '')) ? trim($variation['name']) : 'Biến thể ' . ($index + 1);
            // Tự động cập nhật trạng thái biến thể dựa trên stock_quantity
            if (isset($variation['stock_quantity']) && (int)$variation['stock_quantity'] === 0) {
                $variation['status'] = 'out_of_stock';
            }
        }
        unset($variation);

        $updateData = [
            'name' => $validated['name'],
            'description_short' => $validated['description_short'],
            'description_long' => $validated['description_long'],
            'brand_id' => $validated['brand_id'],
            'status' => $validated['status'],
            'is_featured' => (int)$validated['is_featured'],
        ];

        if ($product->product_type === 'simple') {
            $updateData['stock_quantity'] = (int)($validated['stock_quantity'] ?? 0);
            $updateData['price'] = (float)$validated['price'];
            $updateData['sale_price'] = isset($validated['sale_price']) && $validated['sale_price'] !== '' ? (float)$validated['sale_price'] : null;
            if (isset($validated['sku']) && !empty($validated['sku'])) {
                $updateData['sku'] = $validated['sku'];
            }
        } else {
            $updateData['stock_quantity'] = 0; // Sẽ được tính lại từ biến thể
        }

        if ($request->hasFile('video_path')) {
            $video = $request->file('video_path');
            if ($video->isValid()) {
                // Xóa video cũ nếu có
                if ($product->video_path && Storage::disk('public')->exists($product->video_path)) {
                    Storage::disk('public')->delete($product->video_path);
                }
                $path = $video->store('videos/products', 'public');
                $updateData['video_path'] = $path;
            }
        }

        \Log::info('Updating product', ['id' => $id, 'data' => $updateData]);
        $product->update($updateData);


if ($product->product_type === 'variable') {
    if (empty($processedVariations)) {
        \Log::warning('No variations provided for variable product update', ['product_id' => $product->id]);
        // Không redirect ngay mà thêm thông báo lỗi vào session
        return redirect()->back()->withErrors(['variations' => 'Sản phẩm có biến thể phải có ít nhất một biến thể.'])->withInput();
    }

    // Lấy danh sách ID biến thể hiện tại
    $existingVariationIds = $product->variations()->pluck('id')->toArray();
    $updatedVariationIds = array_filter(array_column($processedVariations, 'id'), fn($id) => !empty($id));

    // Xóa các biến thể không còn trong danh sách cập nhật
    $product->variations()->whereNotIn('id', $updatedVariationIds)->delete();

    // Thu thập các thuộc tính từ input
    $attributes = $request->input('attributes', []);

    foreach ($processedVariations as $index => $variationData) {
        $colorId = $sizeId = $sphericalId = $cylindricalId = null;

        // Parse variation name để lấy thuộc tính
        $variationAttributes = array_map('trim', explode('-', $variationData['name']));

        foreach ($attributes as $attribute) {
            if (empty($attribute['values'])) continue;
            foreach ($attribute['values'] as $value) {
                if (in_array($value, $variationAttributes)) {
                    if ($attribute['type'] === 'color') {
                        $color = Color::where('name', $value)->first();
                        $colorId = $color ? $color->id : null;
                    } elseif ($attribute['type'] === 'size') {
                        $size = Size::where('name', $value)->first();
                        $sizeId = $size ? $size->id : null;
                    } elseif ($attribute['type'] === 'spherical') {
                        $spherical = Spherical::where('value', (float)$value)->first();
                        $sphericalId = $spherical ? $spherical->id : null;
                    } elseif ($attribute['type'] === 'cylindrical') {
                        $cylindrical = Cylindrical::where('value', (float)$value)->first();
                        $cylindricalId = $cylindrical ? $cylindrical->id : null;
                    }
                }
            }
        }

        // Chuẩn bị dữ liệu biến thể
        $variationDataToSave = [
            'product_id' => $product->id,
            'name' => trim($variationData['name'] ?? '') ?: 'Biến thể ' . ($index + 1),
            'sku' => trim($variationData['sku'] ?? '') ?: 'VAR-' . Str::random(8),
            'price' => (float)($variationData['price'] ?? 0),
            'sale_price' => isset($variationData['sale_price']) && is_numeric($variationData['sale_price']) ? (float)$variationData['sale_price'] : null,
            'stock_quantity' => (int)($variationData['stock_quantity'] ?? 0),
            'status' => $variationData['status'] ?? ((int)($variationData['stock_quantity'] ?? 0) > 0 ? 'in_stock' : 'out_of_stock'),
            'color_id' => $colorId,
            'size_id' => $sizeId,
            'spherical_id' => $sphericalId,
            'cylindrical_id' => $cylindricalId,
        ];

        // Cập nhật hoặc tạo biến thể
        if (!empty($variationData['id']) && in_array($variationData['id'], $existingVariationIds)) {
            $variation = Variation::find($variationData['id']);
            $variation?->update($variationDataToSave);
        } else {
            $variation = Variation::create($variationDataToSave);
        }

        // Xử lý ảnh biến thể
        if ($request->hasFile("variations.$index.image")) {
            $image = $request->file("variations.$index.image");
            if ($image->isValid()) {
                // Xóa ảnh cũ
                foreach ($variation->images as $oldImage) {
                    Storage::disk('public')->exists($oldImage->image_path) && Storage::disk('public')->delete($oldImage->image_path);
                    $oldImage->delete();
                }
                // Lưu ảnh mới
                $path = $image->store('variations', 'public');
                $variation->images()->create(['image_path' => $path]);
            }
        }
    }

    // Cập nhật tổng stock_quantity
    $product->stock_quantity = $product->variations->sum('stock_quantity');
    $product->save();
} elseif ($product->product_type === 'variable') {
    \Log::error('No variations provided for variable product update', ['product_id' => $product->id]);
    return redirect()->back()->withErrors(['variations' => 'Sản phẩm có biến thể phải có ít nhất một biến thể.'])->withInput();
}

        \Log::info('Product updated', [
            'id' => $id,
            'stock_quantity_after_update' => $product->stock_quantity,
            'price_after_update' => $product->price,
            'sale_price_after_update' => $product->sale_price,
            'is_featured_after_update' => $product->is_featured,
        ]);

        $product->categories()->sync($validated['categories']);

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
                if ($path) {
                    $product->images()->create(['image_path' => $path, 'is_featured' => true]);
                } else {
                    return redirect()->back()->with('error', 'Không thể lưu ảnh đại diện.');
                }
            }
        }

        if ($request->hasFile('gallery_images')) {
            $product->images()->where('is_featured', false)->delete();
            foreach ($request->file('gallery_images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('images/products', 'public');
                    if ($path) {
                        $product->images()->create(['image_path' => $path, 'is_featured' => false]);
                    }
                }
            }
        }

        return redirect()->route('admin.products.list')
            ->with('success', 'Cập nhật sản phẩm thành công.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.list')
            ->with('success', 'Xóa sản phẩm thành công.');
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
                $product->total_stock = $product->variations->sum('stock_quantity');
                $product->default_price = $product->variations->first()->price ?? 0;
                $product->default_sale_price = $product->variations->first()->sale_price ?? $product->default_price;
            } else {
                $product->total_stock = $product->stock_quantity ?? 0;
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

        // Xóa các hình ảnh liên quan
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        // Xóa các biến thể và hình ảnh của biến thể
        foreach ($product->variations as $variation) {
            foreach ($variation->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }
            $variation->delete();
        }

        // Xóa sản phẩm vĩnh viễn
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
            $product->total_stock = $product->variations->sum('stock_quantity');
            $product->default_price = $product->variations->first()->price ?? 0;
            $product->default_sale_price = $product->variations->first()->sale_price ?? $product->default_price;
        } else {
            $product->total_stock = $product->stock_quantity ?? 0;
            $product->default_price = $product->price ?? 0;
            $product->default_sale_price = $product->sale_price ?? $product->price ?? 0;
        }

        return view('admin.products.show', compact('product'));
    }
}
