@extends('client.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-7">
                <h5 class="fw-bold mb-3">Liên hệ với chúng tôi</h5>
                <p>Mắt Kính Hana Cung cấp gọng kính, hộp kính và mắt kính râm cao cấp theo phong cách trẻ trung và hiện
                    đại</p>
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ và tên">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            placeholder="Nhập số điện thoại">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Nhập nội dung"></textarea>
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
                    Địa chỉ: FPT Polytechnic, Trịnh Văn Bô, Nam Từ Liên, Hà Nội.
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
