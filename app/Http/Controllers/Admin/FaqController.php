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

        if ($request->has('rating') && $request->rating) {
            $query->where('rating', '>=', $request->rating);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $faqs = $query->orderBy('sort_order')->get();
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
            'category' => 'required|string|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $faq = new Faq();
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->category = $request->category;
            $faq->sort_order = $request->sort_order ?? 0;
            $faq->is_active = $request->boolean('is_active', true);

            // Xử lý upload nhiều hình ảnh
            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('faqs', 'public');
                    if ($path) {
                        $images[] = $path;
                    }
                }
                if (!empty($images)) {
                    $faq->images = json_encode($images);
                }
            }

            $faq->save();

            return redirect()->route('admin.faqs.index')
                ->with('success', 'FAQ đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        return view('admin.faqs.show', compact('faq'));
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
            'category' => 'required|string|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->category = $request->category;
            $faq->sort_order = $request->sort_order ?? 0;
            $faq->is_active = $request->boolean('is_active', true);

            // Xử lý upload nhiều hình ảnh
            if ($request->hasFile('images')) {
                // Xóa hình ảnh cũ
                if ($faq->images) {
                    $oldImages = json_decode($faq->images, true);
                    if (is_array($oldImages)) {
                        foreach ($oldImages as $oldImage) {
                            Storage::disk('public')->delete($oldImage);
                        }
                    }
                }

                $images = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('faqs', 'public');
                    if ($path) {
                        $images[] = $path;
                    }
                }
                if (!empty($images)) {
                    $faq->images = json_encode($images);
                }
            }

            $faq->save();

            return redirect()->route('admin.faqs.index')
                ->with('success', 'FAQ đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        // Xóa hình ảnh
        if ($faq->images) {
            $images = json_decode($faq->images, true);
            if (is_array($images)) {
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $faq->delete();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ đã được xóa thành công.');
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
                    if ($faq->images) {
                        $images = json_decode($faq->images, true);
                        if (is_array($images)) {
                            foreach ($images as $image) {
                                Storage::disk('public')->delete($image);
                            }
                        }
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