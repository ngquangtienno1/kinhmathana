@extends('admin.layouts')

@section('title', 'Sửa lý do hủy')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.cancellation_reasons.index') }}">Lý do hủy</a>
    </li>
    <li class="breadcrumb-item active">Sửa lý do hủy</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Sửa lý do hủy</h2>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-8 pe-lg-2">
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{ route('admin.cancellation_reasons.update', $cancellationReason->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="reason">Lý do hủy <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3"
                                required>{{ old('reason', $cancellationReason->reason) }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="type">Loại <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type"
                                name="type" required>
                                <option value="">Chọn loại</option>
                                <option value="customer"
                                    {{ old('type', $cancellationReason->type) == 'customer' ? 'selected' : '' }}>Khách
                                    hàng</option>
                                <option value="admin"
                                    {{ old('type', $cancellationReason->type) == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" id="is_active" name="is_active" type="checkbox"
                                    value="1"
                                    {{ old('is_active', $cancellationReason->is_active) ? 'checked' : '' }} />
                                <label class="form-check-label" for="is_active">Hoạt động</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                            <a class="btn btn-phoenix-secondary"
                                href="{{ route('admin.cancellation_reasons.index') }}">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
