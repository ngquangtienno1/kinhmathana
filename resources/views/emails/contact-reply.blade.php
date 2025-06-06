<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Phản hồi từ {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .original-message {
            margin-top: 20px;
            padding: 15px;
            background-color: #f0f0f0;
            border-left: 4px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Phản hồi từ {{ config('app.name') }}</h2>
    </div>

    <div class="content">
        <p>Xin chào {{ $contact->name }},</p>

        <p>{!! nl2br(e($replyMessage)) !!}</p>

        <div class="original-message">
            <p><strong>Tin nhắn gốc của bạn:</strong></p>
            <p>{!! nl2br(e($contact->message)) !!}</p>
        </div>
    </div>

    <div class="footer">
        <p>Email này được gửi tự động từ hệ thống {{ config('app.name') }}.</p>
        <p>Vui lòng không trả lời email này.</p>
    </div>
</body>

</html>
