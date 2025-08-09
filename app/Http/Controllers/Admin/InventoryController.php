<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Variation;
use App\Models\Product;
use App\Models\ImportDocument;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with(['variation.product', 'product', 'user']);

        // Lọc theo loại giao dịch
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Tìm kiếm theo SKU hoặc tên sản phẩm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('variation', function ($q) use ($search) {
                    $q->where('sku', 'like', "%{$search}%")
                      ->orWhereHas('product', function ($q2) use ($search) {
                          $q2->where('name', 'like', "%{$search}%");
                      });
                })->orWhereHas('product', function ($q) use ($search) {
                    $q->where('sku', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%");
                });
            });
        }

        // Lọc theo tồn kho thấp
        if ($request->filled('low_stock')) {
            $query->where(function ($q) {
                $q->whereHas('variation', function ($q) {
                    $q->whereColumn('stock_quantity', '<=', 'stock_alert_threshold');
                })->orWhereHas('product', function ($q) {
                    $q->where('stock_quantity', '<=', 10); // Giả sử ngưỡng là 10
                });
            });
        }

        $inventories = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();

        return view('admin.inventory.index', compact('inventories', 'categories'));
    }

    public function searchVariations(Request $request)
    {
        $search = $request->input('search', '');
        $category_id = $request->input('category_id', '');

        $variationQuery = Variation::with(['product.categories'])
            ->where(function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });

        $productQuery = Product::with('categories')
            ->where('product_type', 'simple')
            ->where(function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });

        if ($category_id) {
            $variationQuery->whereHas('product.categories', function ($q) use ($category_id) {
                $q->where('categories.id', $category_id);
            });
            $productQuery->whereHas('categories', function ($q) use ($category_id) {
                $q->where('categories.id', $category_id);
            });
        }

        $variations = $variationQuery->take(20)->get();
        $products = $productQuery->take(20)->get();

        $results = [];

        foreach ($products as $product) {
            $results[] = [
                'id' => 'product_' . $product->id,
                'text' => $product->name . ' (SKU: ' . ($product->sku ?? 'N/A') . ')',
            ];
        }

        foreach ($variations as $variation) {
            $results[] = [
                'id' => 'variation_' . $variation->id,
                'text' => ($variation->product->name ?? 'N/A') . ' - ' . ($variation->name ?? 'N/A') . ' (SKU: ' . ($variation->sku ?? 'N/A') . ')',
            ];
        }

        return response()->json([
            'results' => $results
        ]);
    }

    public function getVariationsByProduct(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::with('variations')->find($productId);

        if (!$product || $product->product_type !== 'variable') {
            return response()->json(['variations' => []]);
        }

        $variations = $product->variations->map(function ($variation) {
            return [
                'id' => $variation->id,
                'name' => $variation->name,
                'sku' => $variation->sku,
                'stock_quantity' => $variation->stock_quantity,
            ];
        });

        return response()->json(['variations' => $variations]);
    }

    public function storeBulk(Request $request)
    {
        $messages = [
            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'type.required' => 'Loại giao dịch là bắt buộc.',
            'type.in' => 'Loại giao dịch không hợp lệ.',
            'variations.*.id.required' => 'ID biến thể là bắt buộc.',
            'variations.*.id.integer' => 'ID biến thể phải là số nguyên.',
            'variations.*.id.exists' => 'Biến thể không tồn tại.',
            'variations.*.quantity.integer' => 'Số lượng phải là số nguyên.',
            'variations.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
            'note.string' => 'Ghi chú phải là chuỗi ký tự.',
        ];

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:import,export,adjust',
            'variations.*.id' => 'required|integer|exists:variations,id',
            'variations.*.quantity' => 'nullable|integer|min:1',
            'note' => 'nullable|string',
        ], $messages);

        try {
            DB::transaction(function () use ($validated) {
                $product = Product::findOrFail($validated['product_id']);
                if ($product->product_type !== 'variable') {
                    throw new \Exception('Chỉ sản phẩm có biến thể mới có thể nhập kho hàng loạt.');
                }

                $importDocumentId = null;
                if ($validated['type'] === 'import') {
                    $importDocument = ImportDocument::create([
                        'code' => 'IMP-' . time(),
                        'total_amount' => 0,
                        'import_date' => now(),
                        'status' => 'confirmed',
                        'user_id' => Auth::id(),
                        'note' => $validated['note'],
                    ]);
                    $importDocumentId = $importDocument->id;
                }

                $hasValidVariation = false;
                foreach ($validated['variations'] as $variationId => $variationData) {
                    if (!isset($variationData['id']) || !isset($variationData['quantity']) || $variationData['quantity'] === null || $variationData['quantity'] === '') {
                        continue; // Bỏ qua biến thể không có số lượng
                    }
                    $hasValidVariation = true;
                    $variation = Variation::lockForUpdate()->findOrFail($variationData['id']);
                    if ($validated['type'] === 'export' && $variation->stock_quantity < $variationData['quantity']) {
                        throw new \Exception("Số lượng xuất kho cho biến thể {$variation->name} vượt quá tồn kho hiện tại ({$variation->stock_quantity}).");
                    }

                    if ($validated['type'] === 'import') {
                        $variation->increment('stock_quantity', $variationData['quantity']);
                    } elseif ($validated['type'] === 'export') {
                        $variation->decrement('stock_quantity', $variationData['quantity']);
                    } elseif ($validated['type'] === 'adjust') {
                        $variation->stock_quantity = $variationData['quantity'];
                        $variation->save();
                    }

                    Inventory::create([
                        'variation_id' => $variation->id,
                        'product_id' => $product->id,
                        'type' => $validated['type'],
                        'quantity' => $variationData['quantity'],
                        'reference' => $validated['type'] . '-' . time() . '-' . $variation->id,
                        'note' => $validated['note'],
                        'status' => 'confirmed',
                        'user_id' => Auth::id(),
                        'import_document_id' => $importDocumentId,
                    ]);
                }

                if (!$hasValidVariation) {
                    throw new \Exception('Vui lòng nhập số lượng cho ít nhất một biến thể.');
                }

                $product->stock_quantity = $product->variations->sum('stock_quantity');
                $product->save();
            });

            return redirect()->route('admin.inventory.index')->with('success', 'Giao dịch kho hàng loạt đã được thực hiện.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function searchProducts(Request $request)
    {
        $search = $request->input('search', '');

        $products = Product::where('product_type', 'variable')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            })
            ->take(20)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'text' => $product->name . ' (SKU: ' . ($product->sku ?? 'N/A') . ')',
                ];
            });

        return response()->json(['results' => $products]);
    }

    public function store(Request $request)
    {
        $messages = [
            'target_id.required' => 'Vui lòng chọn sản phẩm hoặc biến thể.',
            'type.required' => 'Loại giao dịch là bắt buộc.',
            'type.in' => 'Loại giao dịch không hợp lệ.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn 0.',
            'note.string' => 'Ghi chú phải là chuỗi ký tự.',
        ];

        $validated = $request->validate([
            'target_id' => 'required',
            'type' => 'required|in:import,export,adjust',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ], $messages);

        DB::transaction(function () use ($validated) {
            $targetType = explode('_', $validated['target_id'])[0];
            $targetId = explode('_', $validated['target_id'])[1];
            $importDocumentId = null;

            if ($targetType === 'variation') {
                $target = Variation::lockForUpdate()->findOrFail($targetId);
                $product = $target->product;

                if ($validated['type'] === 'export' && $target->stock_quantity < $validated['quantity']) {
                    throw new \Exception("Số lượng xuất kho vượt quá tồn kho hiện tại ({$target->stock_quantity}).");
                }

                if ($validated['type'] === 'import') {
                    $target->increment('stock_quantity', $validated['quantity']);
                } elseif ($validated['type'] === 'export') {
                    $target->decrement('stock_quantity', $validated['quantity']);
                } elseif ($validated['type'] === 'adjust') {
                    $target->stock_quantity = $validated['quantity'];
                    $target->save();
                }

                if ($validated['type'] === 'import') {
                    $importDocument = ImportDocument::create([
                        'code' => 'IMP-' . time(),
                        'total_amount' => 0,
                        'import_date' => now(),
                        'status' => 'confirmed',
                        'user_id' => Auth::id(),
                        'note' => $validated['note'],
                    ]);
                    $importDocumentId = $importDocument->id;
                }

                Inventory::create([
                    'variation_id' => $target->id,
                    'product_id' => $product->id,
                    'type' => $validated['type'],
                    'quantity' => $validated['quantity'],
                    'reference' => $validated['type'] . '-' . time(),
                    'note' => $validated['note'],
                    'status' => 'confirmed',
                    'user_id' => Auth::id(),
                    'import_document_id' => $importDocumentId,
                ]);

                $product->stock_quantity = $product->variations->sum('stock_quantity');
                $product->save();
            } elseif ($targetType === 'product') {
                $target = Product::lockForUpdate()->findOrFail($targetId);
                if ($target->product_type !== 'simple') {
                    throw new \Exception('Chỉ sản phẩm đơn giản mới có thể được chọn trực tiếp.');
                }

                if ($validated['type'] === 'export' && $target->stock_quantity < $validated['quantity']) {
                    throw new \Exception("Số lượng xuất kho vượt quá tồn kho hiện tại ({$target->stock_quantity}).");
                }

                if ($validated['type'] === 'import') {
                    $target->increment('stock_quantity', $validated['quantity']);
                } elseif ($validated['type'] === 'export') {
                    $target->decrement('stock_quantity', $validated['quantity']);
                } elseif ($validated['type'] === 'adjust') {
                    $target->stock_quantity = $validated['quantity'];
                    $target->save();
                }

                if ($validated['type'] === 'import') {
                    $importDocument = ImportDocument::create([
                        'code' => 'IMP-' . time(),
                        'total_amount' => 0,
                        'import_date' => now(),
                        'status' => 'confirmed',
                        'user_id' => Auth::id(),
                        'note' => $validated['note'],
                    ]);
                    $importDocumentId = $importDocument->id;
                }

                Inventory::create([
                    'product_id' => $target->id,
                    'variation_id' => null,
                    'type' => $validated['type'],
                    'quantity' => $validated['quantity'],
                    'reference' => $validated['type'] . '-' . time(),
                    'note' => $validated['note'],
                    'status' => 'confirmed',
                    'user_id' => Auth::id(),
                    'import_document_id' => $importDocumentId,
                ]);
            } else {
                throw new \Exception('ID không hợp lệ.');
            }
        });

        return redirect()->route('admin.inventory.index')->with('success', 'Giao dịch kho đã được thực hiện.');
    }

    public function print(Request $request, $id)
    {
        $inventory = Inventory::with(['variation.product', 'product', 'user'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.inventory.print', compact('inventory'));
        return $pdf->download('phieu-kho-' . $inventory->reference . '.pdf');
    }

    public function show($id)
    {
        $inventory = Inventory::with(['variation.product', 'product', 'user', 'importDocument'])->findOrFail($id);
        return view('admin.inventory.show', compact('inventory'));
    }
}
