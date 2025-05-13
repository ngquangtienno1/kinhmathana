@extends('admin.layouts')

@section('title', 'Promotion Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.promotions.index') }}">Promotions</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Promotion Details: {{ $promotion->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.promotions.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Basic Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">ID</th>
                                            <td>{{ $promotion->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $promotion->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Code</th>
                                            <td><code>{{ $promotion->code }}</code></td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td>{{ $promotion->description ?: 'No description provided' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                           <td>
                                            @if($promotion->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>

                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{ $promotion->created_at->format('M d, Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated At</th>
                                            <td>{{ $promotion->updated_at->format('M d, Y H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Discount Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Discount Type</th>
                                            <td>
                                                @if($promotion->discount_type === 'percentage')
                                                    Percentage (%)
                                                @else
                                                    Fixed Amount
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Discount Value</th>
                                            <td>
                                                @if($promotion->discount_type === 'percentage')
                                                    {{ $promotion->discount_value }}%
                                                @else
                                                    ${{ number_format($promotion->discount_value, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Minimum Purchase</th>
                                            <td>
                                                @if($promotion->minimum_purchase > 0)
                                                    ${{ number_format($promotion->minimum_purchase, 2) }}
                                                @else
                                                    No minimum
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Usage Limit</th>
                                            <td>
                                                @if($promotion->usage_limit)
                                                    {{ $promotion->usage_limit }}
                                                @else
                                                    Unlimited
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Current Usage</th>
                                            <td>{{ $promotion->used_count ?: 0 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Start Date</th>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="start_date" id="start_date" class="form-control" value="{{ $promotion->start_date }}" readonly>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" id="start_date_button">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>End Date</th>
                                            <td>{{ $promotion->end_date }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Applied Products</h5>
                                </div>
                                <div class="card-body">
                                    @if($promotion->products->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Product Name</th>
                                                        <th>Price</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($promotion->products as $product)
                                                        <tr>
                                                            <td>{{ $product->id }}</td>
                                                            <td>{{ $product->name }}</td>
                                                            <td>${{ number_format($product->price, 2) }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            This promotion applies to all products.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete Promotion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="{{ asset('v1/vendors/flatpickr/flatpickr.min.css') }}">
<script src="{{ asset('v1/vendors/flatpickr/flatpickr.min.js') }}"></script>
<script>
$(document).ready(function() {
    const startDatePicker = flatpickr("#start_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        altInput: true,
        altFormat: "d/m/Y H:i",
        time_24hr: true,
        allowInput: true
    });
    const endDatePicker = flatpickr("#end_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        altInput: true,
        altFormat: "d/m/Y H:i",
        time_24hr: true,
        allowInput: true
    });
    $("#start_date_button").on("click", function() {
        startDatePicker.open();
    });
    $("#end_date_button").on("click", function() {
        endDatePicker.open();
    });
});
</script>
@endsection 