<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\Order;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = trim($request->input('query'));

            if (empty($query) || strlen($query) < 2) {
                return response()->json([
                    'success' => true,
                    'results' => [],
                    'message' => 'Vui lòng nhập ít nhất 2 ký tự để tìm kiếm'
                ]);
            }

            $results = [];

            // Tìm kiếm sản phẩm
            $products = Product::where('name', 'like', "%{$query}%")
                ->where('status', 'active')
                ->take(5)
                ->get()
                ->map(function ($product) {
                    return [
                        'type' => 'product',
                        'title' => $product->name,
                        'description' => 'Sản phẩm',
                        'url' => route('admin.products.edit', $product->id),
                        'icon' => 'fa-box',
                        'created_at' => $product->created_at
                    ];
                });

            // Tìm kiếm bài viết
            $news = News::where('title', 'like', "%{$query}%")
                ->where('is_active', true)
                ->take(5)
                ->get()
                ->map(function ($news) {
                    return [
                        'type' => 'news',
                        'title' => $news->title,
                        'description' => 'Bài viết',
                        'url' => route('admin.news.edit', $news->id),
                        'icon' => 'fa-newspaper',
                        'created_at' => $news->created_at
                    ];
                });

            // Tìm kiếm đơn hàng
            $orders = Order::where('order_number', 'like', "%{$query}%")
                ->orWhere('customer_name', 'like', "%{$query}%")
                ->take(5)
                ->get()
                ->map(function ($order) {
                    return [
                        'type' => 'order',
                        'title' => "Đơn hàng #{$order->order_number}",
                        'description' => "Khách hàng: {$order->customer_name}",
                        'url' => route('admin.orders.show', $order->id),
                        'icon' => 'fa-shopping-cart',
                        'created_at' => $order->created_at
                    ];
                });

            // Tìm kiếm bình luận
            $comments = Comment::where('content', 'like', "%{$query}%")
                ->where('is_hidden', false)
                ->with('user')
                ->take(5)
                ->get()
                ->map(function ($comment) {
                    return [
                        'type' => 'comment',
                        'title' => substr(strip_tags($comment->content), 0, 50) . '...',
                        'description' => "Bởi: " . ($comment->user ? $comment->user->name : 'Khách'),
                        'url' => route('admin.comments.index'),
                        'icon' => 'fa-comment',
                        'created_at' => $comment->created_at
                    ];
                });

            // Tìm kiếm danh mục
            $categories = Category::where('name', 'like', "%{$query}%")
                ->take(5)
                ->get()
                ->map(function ($category) {
                    return [
                        'type' => 'category',
                        'title' => $category->name,
                        'description' => 'Danh mục sản phẩm',
                        'url' => route('admin.categories.edit', $category->id),
                        'icon' => 'fa-folder',
                        'created_at' => $category->created_at
                    ];
                });

            // Tìm kiếm khuyến mãi
            $promotions = Promotion::where('name', 'like', "%{$query}%")
                ->where('is_active', true)
                ->take(5)
                ->get()
                ->map(function ($promotion) {
                    return [
                        'type' => 'promotion',
                        'title' => $promotion->name,
                        'description' => "Mã: {$promotion->code}",
                        'url' => route('admin.promotions.edit', $promotion->id),
                        'icon' => 'fa-tag',
                        'created_at' => $promotion->created_at
                    ];
                });

            // Gộp tất cả kết quả
            $results = array_merge(
                $products->toArray(),
                $news->toArray(),
                $orders->toArray(),
                $comments->toArray(),
                $categories->toArray(),
                $promotions->toArray()
            );

            // Sắp xếp kết quả theo thời gian mới nhất
            usort($results, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            return response()->json([
                'success' => true,
                'results' => $results,
                'message' => count($results) > 0 ? 'Tìm thấy ' . count($results) . ' kết quả' : 'Không tìm thấy kết quả nào'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tìm kiếm: ' . $e->getMessage()
            ], 500);
        }
    }

    public function searchResults(Request $request)
    {
        $query = trim($request->input('q'));

        if (empty($query) || strlen($query) < 2) {
            return redirect()->back()->with('error', 'Vui lòng nhập ít nhất 2 ký tự để tìm kiếm');
        }

        // Tìm kiếm sản phẩm
        $products = Product::where('name', 'like', "%{$query}%")
            ->where('status', 'active')
            ->paginate(10);

        // Tìm kiếm bài viết
        $news = News::where('title', 'like', "%{$query}%")
            ->where('is_active', true)
            ->paginate(10);

        // Tìm kiếm đơn hàng
        $orders = Order::where('order_number', 'like', "%{$query}%")
            ->orWhere('customer_name', 'like', "%{$query}%")
            ->paginate(10);

        // Tìm kiếm bình luận
        $comments = Comment::where('content', 'like', "%{$query}%")
            ->where('is_hidden', false)
            ->with('user')
            ->paginate(10);

        // Tìm kiếm danh mục
        $categories = Category::where('name', 'like', "%{$query}%")
            ->paginate(10);

        // Tìm kiếm khuyến mãi
        $promotions = Promotion::where('name', 'like', "%{$query}%")
            ->where('is_active', true)
            ->paginate(10);

        return view('admin.search.results', compact(
            'query',
            'products',
            'news',
            'orders',
            'comments',
            'categories',
            'promotions'
        ));
    }
}
