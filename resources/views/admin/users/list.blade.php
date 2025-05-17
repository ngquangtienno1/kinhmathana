
@extends('admin.layouts')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Người dùng</li>
@endsection

@section('content')
<style>
    .contentt{
        margin-top: 0px;
    }
</style>
<div class="contentt">
        <h2 class="text-bold text-body-emphasis mb-5">Danh sách  người dùng</h2>
        <div id="members" data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"page":10,"pagination":true}'>
          <div class="row align-items-center justify-content-between g-3 m  b-4">
            <div class="col col-auto">
              <div class="search-box">
                <form class="position-relative"><input class="form-control search-input search" type="search" placeholder="Search members" aria-label="Search" />
                  <span class="fas fa-search search-box-icon"></span>
                </form>
              </div>
            </div>
       
          </div>
          <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-body-emphasis border-y mt-2 position-relative top-1">
            <div class="table-responsive scrollbar ms-n1 ps-1">
              <table class="table table-sm fs-9 mb-0">
                <thead>
                  <tr>
                    <th class="white-space-nowrap fs-9 align-middle ps-0">
                      <div class="form-check mb-0 fs-8"><input class="form-check-input" id="checkbox-bulk-members-select" type="checkbox" data-bulk-select='{"body":"members-table-body"}' /></div>
                    </th>
                    <th class="sort align-middle" scope="col" data-sort="customer" style="width:15%; min-width:200px;">TÊN</th>
                    <th class="sort align-middle" scope="col" data-sort="email" style="width:15%; min-width:200px;">EMAIL</th>
                    <th class="sort align-middle pe-3" scope="col" data-sort="mobile_number" style="width:20%; min-width:200px;">SỐ ĐIỆN THOẠI</th>
                    <th class="sort align-middle" scope="col" data-sort="city" style="width:10%;">CITY</th>
                    <th class="sort align-middle text-end" scope="col" data-sort="last_active" style="width:21%;  min-width:200px;">HOẠT ĐỘNG</th>
                    <th class="sort align-middle text-end pe-0" scope="col" data-sort="joined" style="width:19%;  min-width:200px;">THAM GIA</th>
                  </tr>
                </thead>
                <tbody class="list" id="members-table-body">
    @foreach($users as $user)
    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
        <td class="fs-9 align-middle ps-0 py-3">
            <div class="form-check mb-0 fs-8">
                <input class="form-check-input" type="checkbox" />
            </div>
        </td>
        <td class="customer align-middle white-space-nowrap">
            <a class="d-flex align-items-center text-body text-hover-1000" href="#!">
                <div class="avatar avatar-m">
                    <img class="rounded-circle" src="{{ asset('assets/img/team/default.webp') }}" alt="" />
                </div>
                <h6 class="mb-0 ms-3 fw-semibold">{{ $user->name }}</h6>
            </a>
        </td>
        <td class="email align-middle white-space-nowrap">
            <a class="fw-semibold" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
        </td>
        <td class="mobile_number align-middle white-space-nowrap">
            <a class="fw-bold text-body-emphasis" href="tel:{{ $user->phone }}">{{ $user->phone }}</a>
        </td>
        <td class="city align-middle white-space-nowrap text-body">
            {{ $user->address ?? 'N/A' }}
        </td>
        <td class="last_active align-middle text-end white-space-nowrap text-body-tertiary">
            {{ $user->updated_at->diffForHumans() }}
        </td>
        <td class="joined align-middle white-space-nowrap text-body-tertiary text-end">
            {{ $user->created_at->format('M d, h:i A') }}
        </td>
    </tr>
    @endforeach
</tbody>

              </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
              <div class="col-auto d-flex">
                <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p><a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
              </div>
              <div class="col-auto d-flex"><button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="mb-0 pagination"></ul><button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
              </div>
            </div>
          </div>
        </div>

      </div>
@endsection