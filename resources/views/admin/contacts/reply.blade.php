@extends('admin.layouts')

@section('title', 'Phản hồi liên hệ')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.contacts.index') }}">Liên hệ</a>
    </li>
    <li class="breadcrumb-item active">Phản hồi</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Phản hồi liên hệ</h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-phoenix-secondary">
                <span class="fas fa-arrow-left me-2"></span>Quay lại
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <h4 class="mb-3">Thông tin liên hệ</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 200px;">Họ tên</th>
                                    <td>{{ $contact->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $contact->email }}</td>
                                </tr>
                                <tr>
                                    <th>Số điện thoại</th>
                                    <td>{{ $contact->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Nội dung</th>
                                    <td>{{ $contact->message }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.contacts.sendReply', $contact->id) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="subject">Tiêu đề email</label>
                        <input class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject"
                            type="text" value="{{ old('subject', 'Phản hồi từ ' . getSetting('website_name')) }}" required />
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="reply_message">Nội dung phản hồi</label>
                        <textarea class="form-control @error('reply_message') is-invalid @enderror" id="reply_message" name="reply_message"
                            rows="10">{{ old('reply_message') }}</textarea>
                        @error('reply_message')
                            <div class="invalid-feedback">{{ $messsage }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input @error('save_as_note') is-invalid @enderror"
                                id="save_as_note" name="save_as_note" type="checkbox" value="1"
                                {{ old('save_as_note') ? 'checked' : '' }} />
                            <label class="form-check-label" for="save_as_note">Lưu nội dung phản hồi làm ghi chú</label>
                            @error('save_as_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">
                            <span class="fas fa-paper-plane me-2"></span>Gửi phản hồi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        let replyEditor = null;
        ClassicEditor
            .create(document.querySelector('#reply_message'))
            .then(editor => { replyEditor = editor; })
            .catch(error => { console.error(error); });

        document.querySelector('form').addEventListener('submit', function(e) {
            if (replyEditor && !replyEditor.getData().trim()) {
                alert('Vui lòng nhập nội dung phản hồi!');
                e.preventDefault();
            }
        });
    </script>
@endpush

@endsection
