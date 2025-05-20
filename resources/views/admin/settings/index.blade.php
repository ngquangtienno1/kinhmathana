@extends('admin.layouts')
@section('title', 'Cài đặt hệ thống')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Cài đặt</a>
    </li>
    <li class="breadcrumb-item active">Cài đặt chung</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Cài đặt chung hệ thống</h2>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <ul class="nav nav-tabs mb-3" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                    type="button" role="tab" aria-controls="general" aria-selected="true">Thông tin chung</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                    type="button" role="tab" aria-controls="shipping" aria-selected="false">Cấu hình vận
                    chuyển</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button"
                    role="tab" aria-controls="email" aria-selected="false">Cấu hình email</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="ai-tab" data-bs-toggle="tab" data-bs-target="#ai" type="button"
                    role="tab" aria-controls="ai" aria-selected="false">Cấu hình AI</button>
            </li>
        </ul>
        <div class="tab-content" id="settingsTabContent">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="website_name">Tên website</label>
                            <input type="text" class="form-control" id="website_name" name="website_name"
                                value="{{ old('website_name', $settings->website_name ?? '') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="logo_url">Logo</label>
                            <div class="mb-2">
                                @if (isset($settings->logo_url))
                                    <img src="{{ $settings->logo_url }}" alt="Logo" class="img-thumbnail"
                                        style="max-height: 100px;">
                                @endif
                            </div>
                            <input type="file" class="form-control" id="logo_url" name="logo_url" accept="image/*">
                            <small class="form-text text-muted">Upload logo mới sẽ thay thế logo hiện tại.</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="contact_email">Email liên hệ</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email"
                                value="{{ old('contact_email', $settings->contact_email ?? '') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="hotline">Hotline</label>
                            <input type="text" class="form-control" id="hotline" name="hotline"
                                value="{{ old('hotline', $settings->hotline ?? '') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ old('address', $settings->address ?? '') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="facebook_url">Facebook</label>
                            <input type="url" class="form-control" id="facebook_url" name="facebook_url"
                                value="{{ old('facebook_url', $settings->facebook_url ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="instagram_url">Instagram</label>
                            <input type="url" class="form-control" id="instagram_url" name="instagram_url"
                                value="{{ old('instagram_url', $settings->instagram_url ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="default_shipping_fee">Phí ship mặc định</label>
                            <input type="number" class="form-control" id="default_shipping_fee"
                                name="default_shipping_fee"
                                value="{{ old('default_shipping_fee', $settings->default_shipping_fee ?? 0) }}"
                                min="0" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="smtp_host">SMTP Host</label>
                            <input type="text" class="form-control" id="smtp_host" name="smtp_host"
                                value="{{ old('smtp_host', $settings->smtp_host ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="smtp_port">SMTP Port</label>
                            <input type="text" class="form-control" id="smtp_port" name="smtp_port"
                                value="{{ old('smtp_port', $settings->smtp_port ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="smtp_username">SMTP Username</label>
                            <input type="text" class="form-control" id="smtp_username" name="smtp_username"
                                value="{{ old('smtp_username', $settings->smtp_username ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="smtp_password">SMTP Password</label>
                            <input type="password" class="form-control" id="smtp_password" name="smtp_password"
                                value="{{ old('smtp_password', $settings->smtp_password ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="smtp_encryption">SMTP Encryption</label>
                            <input type="text" class="form-control" id="smtp_encryption" name="smtp_encryption"
                                value="{{ old('smtp_encryption', $settings->smtp_encryption ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="mail_from_address">Mail From Address</label>
                            <input type="email" class="form-control" id="mail_from_address"
                                name="mail_from_address"
                                value="{{ old('mail_from_address', $settings->mail_from_address ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="mail_from_name">Mail From Name</label>
                            <input type="text" class="form-control" id="mail_from_name" name="mail_from_name"
                                value="{{ old('mail_from_name', $settings->mail_from_name ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="ai" role="tabpanel" aria-labelledby="ai-tab">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="enable_ai_recommendation">Bật AI gợi ý sản phẩm</label>
                            <select class="form-control" id="enable_ai_recommendation"
                                name="enable_ai_recommendation">
                                <option value="0"
                                    {{ old('enable_ai_recommendation', $settings->enable_ai_recommendation ?? 0) == 0 ? 'selected' : '' }}>
                                    Tắt</option>
                                <option value="1"
                                    {{ old('enable_ai_recommendation', $settings->enable_ai_recommendation ?? 0) == 1 ? 'selected' : '' }}>
                                    Bật</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ai_api_key">AI API Key</label>
                            <input type="text" class="form-control" id="ai_api_key" name="ai_api_key"
                                value="{{ old('ai_api_key', $settings->ai_api_key ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="ai_api_endpoint">AI API Endpoint</label>
                            <input type="text" class="form-control" id="ai_api_endpoint" name="ai_api_endpoint"
                                value="{{ old('ai_api_endpoint', $settings->ai_api_endpoint ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Lưu cài đặt</button>
    </form>
</div>
@endsection
