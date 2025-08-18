<x-mail::message>
<div style="text-align:center;margin-bottom:18px;">
    <img src="{{ asset('logo.png') }}" alt="Logo Kính mắt HANA" style="height:48px;">
</div>

<p>Xin chào,</p>

<p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Nếu bạn không gửi yêu cầu này, vui lòng bỏ qua email này.</p>

<p>Để đặt lại mật khẩu, vui lòng nhấn vào liên kết bên dưới:</p>

@isset($actionText)
<x-mail::button :url="$actionUrl" color="primary">
    {{ $actionText }}
</x-mail::button>
@endisset

<p style="margin-top:18px;color:#d32f2f;font-size:0.98rem;">Lưu ý: Liên kết sẽ hết hạn sau 60 phút vì lý do bảo mật.</p>

<p>Nếu bạn gặp bất kỳ sự cố nào trong quá trình đặt lại mật khẩu, hãy liên hệ với bộ phận hỗ trợ của chúng tôi để được giúp đỡ.</p>

<p style="margin-top:24px;">Trân trọng,<br>
Đội ngũ hỗ trợ <b>Kính mắt HANA</b></p>
</x-mail::message>
