<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phản hồi từ {{ getSetting('website_name') }}</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background: #f0f2f5;
            color: #1e293b;
            line-height: 1.8;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 700px;
            margin: 48px auto;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
        }

        .header {
            background: linear-gradient(135deg, #6b21a8 0%, #3b82f6 100%);
            color: #ffffff;
            padding: 60px 40px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://www.transparenttextures.com/patterns/stardust.png');
            opacity: 0.15;
            z-index: 0;
        }

        .header img {
            max-height: 64px;
            margin-bottom: 24px;
            border-radius: 12px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease;
        }

        .header img:hover {
            transform: scale(1.05);
        }

        .header h1 {
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            margin: 0;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 1.05rem;
            opacity: 0.9;
            margin-top: 12px;
            position: relative;
            z-index: 1;
        }

        .banner {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(107, 33, 168, 0.1) 100%);
            padding: 16px;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .banner p {
            font-size: 0.95rem;
            color: #4b5563;
            margin: 0;
        }

        .content {
            padding: 56px 48px;
            background: #ffffff;
        }

        .content p {
            font-size: 1.2rem;
            margin-bottom: 28px;
            color: #374151;
        }

        .content strong {
            color: #111827;
            font-weight: 700;
        }

        .button-group {
            display: flex;
            gap: 16px;
            justify-content: center;
            margin: 32px 0 0;
        }

        .reply-btn,
        .support-btn {
            display: inline-flex;
            align-items: center;
            padding: 14px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .reply-btn {
            background: #3b82f6;
            color: #ffffff !important;
        }

        .reply-btn:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }

        .support-btn {
            background: #f3e8ff;
            color: #6b21a8 !important;
        }

        .support-btn:hover {
            background: #e9d5ff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(107, 33, 168, 0.3);
        }

        .reply-btn img,
        .support-btn img {
            width: 22px;
            height: 22px;
            margin-right: 10px;
            vertical-align: middle;
        }

        .original-message {
            margin-top: 48px;
            padding: 28px;
            background: #f9fafc;
            border-radius: 16px;
            border-left: 6px solid #6b21a8;
            position: relative;
        }

        .original-message::before {
            content: '💬';
            position: absolute;
            top: 28px;
            left: -24px;
            font-size: 1.8rem;
            color: #6b21a8;
            transform: rotate(-10deg);
        }

        .original-message p {
            margin: 0;
            color: #4b5563;
            font-size: 1.1rem;
        }

        .footer {
            background: linear-gradient(180deg, #f9fafc 0%, #f1f5f9 100%);
            color: #6b7280;
            text-align: center;
            font-size: 0.9rem;
            padding: 40px 48px;
            border-top: 1px solid #e5e7eb;
        }

        .footer a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .social-links {
            margin-top: 16px;
            display: flex;
            justify-content: center;
            gap: 16px;
        }

        .social-links a {
            display: inline-block;
        }

        .social-links img {
            width: 24px;
            height: 24px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .social-links img:hover {
            opacity: 1;
        }

        /* Responsive design */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 24px 12px;
                border-radius: 16px;
            }

            .header {
                padding: 40px 20px;
            }

            .header h1 {
                font-size: 1.75rem;
            }

            .content {
                padding: 40px 20px;
            }

            .button-group {
                flex-direction: column;
                gap: 12px;
            }

            .reply-btn,
            .support-btn {
                display: block;
                text-align: center;
                padding: 12px 24px;
            }

            .original-message {
                padding: 20px;
            }

            .original-message::before {
                left: -18px;
                font-size: 1.5rem;
            }

            .footer {
                padding: 32px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ getLogoUrl() }}" alt="Logo" />
            <h1>Phản hồi từ {{ getSetting('website_name') }}</h1>
            <p>Cảm ơn bạn đã liên hệ! Chúng tôi luôn sẵn sàng hỗ trợ.</p>
        </div>
        <div class="banner">
            <p>📢 Đừng bỏ lỡ các cập nhật mới nhất từ chúng tôi!</p>
        </div>
        <div class="content">
            <p>Xin chào <strong>{{ $contact->name }}</strong>,</p>
            <p>{!! nl2br(e(strip_tags($replyMessage))) !!}</p>
            <div class="button-group">
                <a href="mailto:{{ $contact->email }}" class="reply-btn">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/reply-arrow.png" alt="Reply Icon" />
                    Trả lời nhanh
                </a>
                <a href="{{ getSetting('website_url') }}/support" class="support-btn">
                    <img src="https://img.icons8.com/ios-filled/50/6b21a8/help.png" alt="Support Icon" />
                    Xem thêm hỗ trợ
                </a>
            </div>
            <div class="original-message">
                <p><strong>Tin nhắn gốc của bạn:</strong></p>
                <p>{!! nl2br(e($contact->message)) !!}</p>
            </div>
        </div>
        <div class="footer">
            Email này được gửi tự động từ hệ thống <strong>{{ getSetting('website_name') }}</strong>.<br>
            Cần hỗ trợ thêm? Liên hệ qua <a href="mailto:{{ getSetting('support_email') }}">đây</a> hoặc truy cập <a
                href="{{ getSetting('website_url') }}">website của chúng tôi</a>.
            <div class="social-links">
                <a href="{{ getSetting('social_twitter') }}"><img
                        src="https://img.icons8.com/ios-filled/50/6b7280/twitter.png" alt="Twitter" /></a>
                <a href="{{ getSetting('social_facebook') }}"><img
                        src="https://img.icons8.com/ios-filled/50/6b7280/facebook-new.png" alt="Facebook" /></a>
                <a href="{{ getSetting('social_instagram') }}"><img
                        src="https://img.icons8.com/ios-filled/50/6b7280/instagram-new.png" alt="Instagram" /></a>
            </div>
        </div>
    </div>
</body>

</html>
