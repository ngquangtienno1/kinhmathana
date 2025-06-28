<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqClientController extends Controller
{
    public function index(Request $request) {
        $query = Faq::where('is_active', true);

        // Tìm kiếm theo từ khóa
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        // Lọc theo category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        $faqs = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->get();

        // Nhóm FAQ theo category
        $faqsByCategory = $faqs->groupBy('category');

        // Lấy danh sách các category có FAQ
        $categories = $faqs->pluck('category')->unique()->values();

        // FAQ nổi bật (có rating cao)
        $featuredFaqs = $faqs->where('rating', '>=', 4)->take(5);

        return view('client.faq', compact('faqs', 'faqsByCategory', 'categories', 'featuredFaqs'));
    }
}
