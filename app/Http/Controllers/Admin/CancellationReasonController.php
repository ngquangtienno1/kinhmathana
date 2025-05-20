<?php

namespace App\Http\Controllers\Admin;

use App\Models\CancellationReason;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CancellationReasonController extends Controller
{
    public function index(Request $request)
    {
        $query = CancellationReason::query();

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            }
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reason', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $cancellationReasons = $query->get();
        $activeCount = CancellationReason::where('is_active', true)->count();
        $deletedCount = CancellationReason::onlyTrashed()->count();
        $adminCount = CancellationReason::where('type', 'admin')->count();
        $customerCount = CancellationReason::where('type', 'customer')->count();

        return view('admin.cancellation_reasons.index', compact(
            'cancellationReasons',
            'activeCount',
            'deletedCount',
            'adminCount',
            'customerCount'
        ));
    }

    public function create()
    {
        return view('admin.cancellation_reasons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string',
            'type' => 'required|in:customer,admin',
            'is_active' => 'boolean'
        ]);

        CancellationReason::create($request->all());

        return redirect()->route('admin.cancellation_reasons.index')
            ->with('success', 'Lý do hủy đã được tạo thành công.');
    }

    public function show($id)
    {
        $cancellationReason = CancellationReason::findOrFail($id);
        return view('admin.cancellation_reasons.show', compact('cancellationReason'));
    }

    public function edit($id)
    {
        $cancellationReason = CancellationReason::findOrFail($id);
        return view('admin.cancellation_reasons.edit', compact('cancellationReason'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string',
            'type' => 'required|in:customer,admin',
            'is_active' => 'boolean'
        ]);

        $cancellationReason = CancellationReason::findOrFail($id);
        $cancellationReason->update($request->all());

        return redirect()->route('admin.cancellation_reasons.index')
            ->with('success', 'Lý do hủy đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $cancellationReason = CancellationReason::findOrFail($id);
        $cancellationReason->delete();

        return redirect()->route('admin.cancellation_reasons.index')
            ->with('success', 'Lý do hủy đã được xóa thành công.');
    }

    public function bin()
    {
        $cancellationReasons = CancellationReason::onlyTrashed()->latest()->paginate(10);
        return view('admin.cancellation_reasons.bin', compact('cancellationReasons'));
    }

    public function restore($id)
    {
        $cancellationReason = CancellationReason::withTrashed()->findOrFail($id);
        $cancellationReason->restore();

        return redirect()->route('admin.cancellation_reasons.bin')
            ->with('success', 'Lý do hủy đã được khôi phục thành công.');
    }

    public function forceDelete($id)
    {
        $cancellationReason = CancellationReason::withTrashed()->findOrFail($id);
        $cancellationReason->forceDelete();

        return redirect()->route('admin.cancellation_reasons.bin')
            ->with('success', 'Lý do hủy đã được xóa vĩnh viễn.');
    }
}
