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
        $query = Inventory::with(['variation.product', 'user']);

        // Lọc theo loại giao dịch
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Tìm kiếm theo SKU hoặc tên sản phẩm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('variation', function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Lọc theo tồn kho thấp
        if ($request->filled('low_stock')) {
            $query->whereHas('variation', function ($q) {
                $q->whereColumn('stock_quantity', '<=', 'stock_alert_threshold');
            });
        }

        $inventories = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all(); // Lấy danh sách danh mục

        return view('admin.inventory.index', compact('inventories', 'categories'));
    }

    public function searchVariations(Request $request)
    {
        $search = $request->input('search', '');
        $category_id = $request->input('category_id', '');

        $query = Variation::with(['product.categories'])
            ->where(function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });

        // Lọc theo danh mục
        if ($category_id) {
            $query->whereHas('product.categories', function ($q) use ($category_id) {
                $q->where('categories.id', $category_id);
            });
        }

        $variations = $query->take(20)->get();

        return response()->json([
            'results' => $variations->map(function ($variation) {
                return [
                    'id' => $variation->id,
                    'text' => ($variation->product->name ?? 'N/A') . ' - ' . ($variation->name ?? 'N/A') . ' (SKU: ' . ($variation->sku ?? 'N/A') . ')'
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $messages = [
            'variation_id.required' => 'Vui lòng chọn biến thể hoặc sản phẩm.',
            'variation_id.exists' => 'Biến thể hoặc sản phẩm không hợp lệ.',
            'type.required' => 'Loại giao dịch là bắt buộc.',
            'type.in' => 'Loại giao dịch không hợp lệ.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn 0.',
            'note.string' => 'Ghi chú phải là chuỗi ký tự.',
        ];

        $validated = $request->validate([
            'variation_id' => 'required|exists:variations,id',
            'type' => 'required|in:import,export,adjust',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ], $messages);

        DB::transaction(function () use ($validated) {
            $variation = Variation::lockForUpdate()->findOrFail($validated['variation_id']);
            $importDocumentId = null;

            if ($validated['type'] === 'export' && $variation->stock_quantity < $validated['quantity']) {
                throw new \Exception('Tồn kho không đủ để xuất.');
            }

            // Tạo import_document nếu là nhập kho
            if ($validated['type'] === 'import') {
                $importDocument = ImportDocument::create([
                    'code' => 'IMP-' . time(),
                    'total_amount' => 0, // Cập nhật sau nếu cần
                    'import_date' => now(),
                    'status' => 'confirmed',
                    'user_id' => Auth::id(),
                    'note' => $validated['note'],
                ]);
                $importDocumentId = $importDocument->id;
            }

            // Cập nhật stock_quantity
            if ($validated['type'] === 'import') {
                $variation->increment('stock_quantity', $validated['quantity']);
            } elseif ($validated['type'] === 'export') {
                $variation->decrement('stock_quantity', $validated['quantity']);
            } elseif ($validated['type'] === 'adjust') {
                $variation->stock_quantity = $validated['quantity'];
                $variation->save();
            }

            // Ghi log vào inventories
            Inventory::create([
                'variation_id' => $variation->id,
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'reference' => $validated['type'] . '-' . time(),
                'note' => $validated['note'],
                'status' => 'confirmed',
                'user_id' => Auth::id(),
                'import_document_id' => $importDocumentId,
            ]);

            // Cập nhật stock_quantity của product
            $product = $variation->product;
            $product->stock_quantity = $product->variations->sum('stock_quantity');
            $product->save();
        });

        return redirect()->route('admin.inventory.index')->with('success', 'Giao dịch kho đã được thực hiện.');
    }

    public function print(Request $request, $id)
    {
        $inventory = Inventory::with(['variation.product', 'user'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.inventory.print', compact('inventory'));
        return $pdf->download('phieu-kho-' . $inventory->reference . '.pdf');
    }
}
