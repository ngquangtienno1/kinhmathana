@extends('admin.layouts')
@section('title', 'Chỉnh sửa FAQ')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.faqs.index') }}">FAQ</a>
    </li>
    <li class="breadcrumb-item active">Chỉnh sửa FAQ</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chỉnh sửa FAQ</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="question">Câu hỏi <span class="text-danger">*</span></label>
                        <input class="form-control @error('question') is-invalid @enderror" id="question" name="question"
                            type="text" value="{{ old('question', $faq->question) }}" required />
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="answer">Câu trả lời <span class="text-danger">*</span></label>
                        <textarea id="answer" name="answer" class="form-control @error('answer') is-invalid @enderror" rows="8">{{ old('answer', $faq->answer) }}</textarea>
                        @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="category">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                            <option value="">Chọn danh mục</option>
                            <option value="Chung" {{ old('category', $faq->category) == 'Chung' ? 'selected' : '' }}>Chung</option>
                            <option value="Sản phẩm" {{ old('category', $faq->category) == 'Sản phẩm' ? 'selected' : '' }}>Sản phẩm</option>
                            <option value="Vận chuyển" {{ old('category', $faq->category) == 'Vận chuyển' ? 'selected' : '' }}>Vận chuyển</option>
                            <option value="Thanh toán" {{ old('category', $faq->category) == 'Thanh toán' ? 'selected' : '' }}>Thanh toán</option>
                            <option value="Bảo hành" {{ old('category', $faq->category) == 'Bảo hành' ? 'selected' : '' }}>Bảo hành</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="images">Hình ảnh</label>
                        @if($faq->images)
                            @php
                                $images = json_decode($faq->images, true);
                            @endphp
                            @if(is_array($images))
                                <div class="mb-2">
                                    <p class="mb-1">Hình ảnh hiện tại:</p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        @foreach($images as $image)
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $image) }}" alt="FAQ Image" class="img-thumbnail" style="max-width: 150px; height: 150px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                        <input class="form-control @error('images') is-invalid @enderror" id="images" name="images[]"
                            type="file" accept="image/*" multiple />
                        <small class="text-muted">Định dạng: jpeg, png, jpg, gif. Kích thước tối đa: 2MB. Để trống nếu không muốn thay đổi hình ảnh</small>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="image-preview" class="mt-2 d-flex gap-2 flex-wrap"></div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="sort_order">Thứ tự sắp xếp</label>
                        <input class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order"
                            type="number" value="{{ old('sort_order', $faq->sort_order) }}" min="0" />
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" id="is_active" name="is_active" type="checkbox"
                                value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_active">Hoạt động</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                            <a href="{{ route('admin.faqs.index') }}" class="btn btn-light">Hủy</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#answer'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'],
                language: 'vi'
            })
            .catch(error => {
                console.error(error);
            });

        // Xử lý preview hình ảnh
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';

            [...e.target.files].forEach(file => {
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'position-relative';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="img-thumbnail" style="max-width: 150px; height: 150px; object-fit: cover;">
                        `;
                        preview.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush

@endsection
