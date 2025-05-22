<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Faq::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                    ->orWhere('answer', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $faqs = $query->orderBy('sort_order')->get();
        // $deletedCount = Faq::onlyTrashed()->count();
        $activeCount = Faq::where('is_active', true)->count();

        return view('admin.faqs.index', compact('faqs', 'activeCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('faqs', $imageName, 'public');
            $data['image'] = 'storage/faqs/' . $imageName;
        }

        Faq::create($data);
        return redirect()->route('admin.faqs.index')->with('success', 'Thêm FAQ thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($faq->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $faq->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('faqs', $imageName, 'public');
            $data['image'] = 'storage/faqs/' . $imageName;
        }

        $faq->update($data);
        return redirect()->route('admin.faqs.index')->with('success', 'Cập nhật FAQ thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        // Xóa ảnh nếu có
        if ($faq->image) {
            Storage::disk('public')->delete(str_replace('storage/', '', $faq->image));
        }

        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'Xóa FAQ thành công');
    }

    public function updateStatus(Request $request, Faq $faq)
    {
        $validator = Validator::make($request->all(), [
            'is_active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
        }

        $faq->update($validator->validated());
        return response()->json(['success' => true]);
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một FAQ để xóa.');
        }
        try {
            foreach ($ids as $id) {
                $faq = Faq::find($id);
                if ($faq) {
                    if ($faq->image) {
                        \Storage::disk('public')->delete(str_replace('storage/', '', $faq->image));
                    }
                    $faq->delete();
                }
            }
            return redirect()->route('admin.faqs.index')->with('success', 'Đã xóa mềm các FAQ đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa: ' . $e->getMessage());
        }
    }
}