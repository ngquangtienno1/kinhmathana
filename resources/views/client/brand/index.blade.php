@extends('client.layouts.app')

@section('content')
    <section class="pt-5 pb-9">
        <div class="container-small">
            <nav class="mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thương hiệu</li>
                </ol>
            </nav>
            <h2 class="mb-1">Thương hiệu</h2>
            <p class="mb-5 text-body-tertiary fw-semibold">Các thương hiệu đối tác của chúng tôi</p>
            <div class="row gx-3 gy-5">
                @foreach ($brands as $brand)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 hover-actions-trigger btn-reveal-trigger">
                        <div class="border border-translucent d-flex flex-center rounded-3 mb-3 p-0" style="height:180px;">
                            <img class="w-100 h-100" style="object-fit: cover;"
                                src="{{ $brand->image ? asset('storage/' . $brand->image) : 'https://via.placeholder.com/150x100?text=No+Image' }}"
                                alt="{{ $brand->name }}" />
                        </div>
                        <h5 class="mb-2">{{ $brand->name }}</h5>
                        <a class="btn btn-link p-0" href="#">Xem thêm<span
                                class="fas fa-chevron-right ms-1 fs-10"></span></a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
