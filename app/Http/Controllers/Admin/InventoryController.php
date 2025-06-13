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
            'id' => 'product_' . $product->id, // Sửa thành product_
            'text' => $product->name . ' (SKU: ' . ($product->sku ?? 'N/A') . ')',
        ];
    }

    foreach ($variations as $variation) {
        $results[] = [
            'id' => 'variation_' . $variation->id, // Sửa thành variation_
            'text' => ($variation->product->name ?? 'N/A') . ' - ' . ($variation->name ?? 'N/A') . ' (SKU: ' . ($variation->sku ?? 'N/A') . ')',
        ];
    }

    return response()->json([
        'results' => $results
    ]);
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
                throw new \Exception('Tồn kho không đủ để xuất.');
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
                throw new \Exception('Tồn kho không đủ để xuất.');
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
                'variation_id' => null, // Rõ ràng đặt variation_id là null
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
}
