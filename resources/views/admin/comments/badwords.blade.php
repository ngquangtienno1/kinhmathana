@extends('admin.layouts')

@section('title', 'Quản lý từ cấm')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.comments.index') }}">Bình luận</a></li>
    <li class="breadcrumb-item active">Quản lý từ cấm</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Quản lý từ cấm</h2>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('admin.comments.index') }}" class="btn btn-phoenix-secondary">
                    <span class="fas fa-arrow-left me-2"></span>Quay lại danh sách bình luận
                </a>
            </div>
        </div>

        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <form action="{{ route('admin.comments.badwords.store') }}" method="POST"
                    class="d-flex gap-2 align-items-center">
                    @csrf
                    <input type="text" name="word" class="form-control @error('word') is-invalid @enderror"
                        placeholder="Nhập từ cấm mới" required style="width: 250px;">
                    <button type="submit" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Thêm từ
                        cấm</button>
                    @error('word')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>

        <div
            class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-8 mb-0 border-top border-translucent">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs-8 align-middle ps-0" style="width:50px;">ID</th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" data-sort="word">Từ cấm
                            </th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:100px;">Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($badWords as $badWord)
                            <tr class="position-static">
                                <td class="align-middle ps-0 py-2">{{ $loop->iteration }}</td>
                                <td class="align-middle ps-4 py-2">{{ $badWord->word }}</td>
                                <td class="align-middle text-end pe-0 ps-4 py-2 btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <form action="{{ route('admin.comments.badwords.destroy', $badWord->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa từ cấm này?');">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">Chưa có từ cấm nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
