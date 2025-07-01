@extends('client.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-7">
                <h5 class="fw-bold mb-3">Liên hệ với chúng tôi</h5>
                <p>Mắt Kính Hana cung cấp gọng kính, hộp kính và mắt kính râm cao cấp theo phong cách trẻ trung và hiện đại
                </p>

                {{-- Thông báo thành công --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Hiển thị lỗi --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('client.contact.create') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Nhập họ và tên" value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email"
                            value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Nhập nội dung">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi liên hệ</button>
                </form>
            </div>

            <div class="col-md-5">
                <h5 class="fw-bold mb-3">Hệ thống cửa hàng</h5>
                <div class="mb-2">
                    <span class="fw-bold text-warning">&#9632;</span>
                    <span class="fw-bold">Mắt Kính Hana</span>
                </div>
                <div class="mb-2">
                    Địa chỉ: FPT Polytechnic, Trịnh Văn Bô, Nam Từ Liêm, Hà Nội.
                </div>
                <div class="mb-3">
                    <span class="fw-bold">Bản đồ</span>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3723.8660097932298!2d105.7445193750317!3d21.03804663061356!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1zRlBUIFBvbHl0ZWNobmljLCBUcuG7i25oIFbEg24gQsO0LCBOYW0gVOG7qyBMacOqbSwgSMOgIE7hu5lp!5e0!3m2!1svi!2s!4v1751333364908!5m2!1svi!2s"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="mb-2">
                    Mở cửa: 9h00 am - 22h00 pm
                </div>
                <div class="mb-2">
                    Hotline: <span class="text-warning fw-bold">0912345678</span>
                </div>
            </div>

        </div>

    </div>
@endsection
