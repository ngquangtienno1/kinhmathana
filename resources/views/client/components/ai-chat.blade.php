@php
$settings = \App\Models\WebsiteSetting::first();
@endphp

@if($settings && $settings->ai_chat_enabled)
<!-- AI Chat Bot cho Hana Optical -->
<div id="ai-chat-toggle-btn" class="ai-chat-toggle-btn">
    <button class="btn rounded-circle shadow d-flex align-items-center justify-content-center ai-toggle-button">
        <i class="fas fa-robot"></i>
        <div class="ai-badge">AI</div>
    </button>
    <div id="ai-chat-tooltip" class="ai-chat-tooltip">
        <div class="tooltip-title">🤖 Hana AI Assistant</div>
        <div class="tooltip-subtitle">Tư vấn kính mắt, màu sắc, phong thủy</div>
    </div>
</div>

<!-- Khung AI Chat -->
<div id="ai-chat-container" class="ai-chat-container">
    <div class="ai-chat-wrapper">
        <!-- Header -->
        <div class="ai-chat-header">
            <div class="ai-chat-header-left">
                <div class="ai-chat-avatar">
                    <i class="fas fa-robot text-white"></i>
                </div>
                <div class="ai-chat-info">
                    <h6>Hana AI Assistant</h6>
                    <p>Tư vấn kính mắt chuyên nghiệp</p>
                    <small>
                        @if(auth()->check())
                        Giới hạn: 5 tin nhắn/giờ
                        @else
                        Vui lòng đăng nhập để chat
                        @endif
                    </small>
                </div>
            </div>
            <div class="ai-chat-actions">
                <button id="ai-chat-clear-btn" class="ai-chat-btn" title="Xóa lịch sử">
                    <i class="fas fa-trash"></i>
                </button>
                <button id="ai-chat-reset-limit-btn" class="ai-chat-btn" title="Reset giới hạn chat"
                    style="display: none;">
                    <i class="fas fa-redo"></i>
                </button>
                <button id="ai-chat-minimize-btn" class="ai-chat-btn">
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <!-- Khung AI Chat -->
        <div id="ai-chat-container" class="hana-ai-container">
            <div class="hana-ai-wrapper">
                <!-- Header -->
                <div class="hana-ai-header">
                    <div class="hana-ai-header-left">
                        <div class="hana-ai-avatar">
                            <i class="fas fa-robot text-white"></i>
                        </div>
                        <div class="hana-ai-info">
                            <h6>Hana AI Assistant</h6>
                            <p>Tư vấn kính mắt chuyên nghiệp</p>
                            <small>
                                @if (auth()->check())
                                Giới hạn: 20 tin nhắn/giờ
                                @else
                                Giới hạn: 5 tin nhắn/giờ
                                @endif
                            </small>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-start;">
                        <span
                            style="display: inline-block; padding: 12px 16px; border-radius: 18px; font-size: 14px; background: #fff; color: #333; box-shadow: 0 2px 8px rgba(0,0,0,0.08); word-break: break-word; border: 1px solid #e5e7eb;">
                            @if(auth()->check())
                            👋 Xin chào {{ auth()->user()->name }}! Tôi là Hana AI Assistant, chuyên gia tư vấn kính
                            mắt. Tôi có thể giúp bạn:
                            <br>• Chọn kính phù hợp với khuôn mặt
                            <br>• Tư vấn màu sắc và kiểu dáng
                            <br>• Giải đáp về phong thủy kính mắt
                            <br>• Thông tin về các loại kính
                            <br><br>Hãy hỏi tôi bất cứ điều gì về kính mắt nhé! 😊
                            @else
                            🔐 Vui lòng đăng nhập để sử dụng AI Chat
                            <br><br><a href="/login" style="color: #007bff; text-decoration: underline;">Đăng nhập
                                ngay</a>
                            @endif
                        </span>
                        <span style="font-size:11px;color:#999;margin-top:4px;">Vừa xong</span>
                    </div>
                </div>

                <!-- Messages -->
                <div id="ai-chat-messages" class="hana-ai-messages">
                    <!-- Tin nhắn chào mừng -->
                    <div class="d-flex mb-3 justify-content-start">
                        <div style="max-width: 80%; display: flex; align-items: flex-end; gap: 8px;">
                            <div
                                style="width: 32px; height: 32px; background: #232323; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-robot text-white" style="font-size: 14px;"></i>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                <span
                                    style="display: inline-block; padding: 12px 16px; border-radius: 18px; font-size: 14px; background: #fff; color: #333; box-shadow: 0 2px 8px rgba(0,0,0,0.08); word-break: break-word; border: 1px solid #e5e7eb;">
                                    👋 Xin chào! Tôi là Hana AI Assistant, chuyên gia tư vấn kính mắt. Tôi có thể giúp
                                    bạn:
                                    <br>• Chọn kính phù hợp với khuôn mặt
                                    <br>• Tư vấn màu sắc và kiểu dáng
                                    <br>• Giải đáp về phong thủy kính mắt
                                    <br>• Thông tin về các loại kính
                                    <br><br>Hãy hỏi tôi bất cứ điều gì về kính mắt nhé! 😊
                                </span>
                                <span style="font-size:11px;color:#999;margin-top:4px;">Vừa xong</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Questions -->
                    <div class="d-flex mb-3 justify-content-start">
                        <div style="max-width: 80%; display: flex; align-items: flex-end; gap: 8px;">
                            <div
                                style="width: 32px; height: 32px; background: #232323; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-robot text-white" style="font-size: 14px;"></i>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px;">
                                <span style="font-size: 12px; color: #666; margin-bottom: 4px;">💡 Câu hỏi nhanh:</span>
                                <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                    <button class="hana-ai-quick-btn"
                                        data-question="Tư vấn chọn kính cho khuôn mặt tròn">Khuôn mặt tròn</button>
                                    <button class="hana-ai-quick-btn"
                                        data-question="Kính mắt phong thủy có tác dụng gì?">Phong thủy</button>
                                    <button class="hana-ai-quick-btn" data-question="Giá kính mắt khoảng bao nhiêu?">Giá
                                        cả</button>
                                    <button class="hana-ai-quick-btn" data-question="Cách bảo quản kính mắt">Bảo
                                        quản</button>
                                    <button class="hana-ai-quick-btn" data-question="Địa chỉ cửa hàng ở đâu?">Địa
                                        chỉ</button>
                                    <button class="hana-ai-quick-btn"
                                        data-question="Hotline liên hệ là gì?">Hotline</button>
                                    <button class="hana-ai-quick-btn" data-question="Có những loại kính nào?">Sản
                                        phẩm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input -->
                <div class="hana-ai-input-area">
                    <input class="hana-ai-input" type="text" id="ai-chat-input"
                        placeholder="Nhập câu hỏi về kính mắt..." autocomplete="off">
                    <button class="hana-ai-send-btn" id="ai-chat-send-btn">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* AI Chat Toggle Button */
        .ai-chat-toggle-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 10000;
        }

        .ai-toggle-button {
            width: 60px;
            height: 60px;
            background: #232323;
            color: #fff;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: relative;
            animation: pulse 2s infinite;
            transition: all 0.3s ease;
        }

        .ai-toggle-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
        }

        .ai-toggle-button i {
            font-size: 1.5rem;
        }

        .ai-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            background: #232323;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: white;
            font-weight: bold;
            animation: bounce 1s infinite;
        }

        /* AI Chat Tooltip */
        .ai-chat-tooltip {
            display: none;
            position: absolute;
            left: 70px;
            bottom: 0;
            background: #fff;
            color: #333;
            border: 1px solid #e5e7eb;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            white-space: nowrap;
            z-index: 10001;
            max-width: 200px;
        }

        .tooltip-title {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .tooltip-subtitle {
            font-size: 12px;
            color: #666;
        }

        /* AI Chat Container */
        .ai-chat-container {
            position: fixed;
            bottom: 100px;
            left: 20px;
            z-index: 9999;
            width: 380px;
            max-width: 90vw;
            display: none;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            background: #fff;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .ai-chat-wrapper {
            display: flex;
            flex-direction: column;
            height: 500px;
        }

        /* AI Chat Header */
        .ai-chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: #232323;
            border-radius: 12px 12px 0 0;
        }

        .ai-chat-header-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .ai-chat-avatar {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ai-chat-info h6 {
            font-weight: bold;
            color: white;
            font-size: 16px;
            margin: 0;
        }

        .ai-chat-info p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            margin: 0;
        }

        .ai-chat-info small {
            color: rgba(255, 255, 255, 0.5);
            font-size: 10px;
        }

        .ai-chat-actions {
            display: flex;
            gap: 0.5rem;
        }

        .ai-chat-btn {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ai-chat-btn:hover {
            background: white;
            transform: scale(1.1);
        }

        /* AI Chat Messages */
        .ai-chat-messages {
            flex-grow: 1;
            padding: 1rem;
            overflow-y: auto;
            background: #fafafa;
            scrollbar-width: thin;
            scrollbar-color: #c1c1c1 #f1f1f1;
        }

        .ai-chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .ai-chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .ai-chat-messages::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .ai-chat-messages::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* AI Chat Input */
        .ai-chat-input-area {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            background: #fff;
            border-radius: 0 0 12px 12px;
            border-top: 1px solid #e5e7eb;
        }

        .ai-chat-input {
            flex-grow: 1;
            border: none;
            border-radius: 25px;
            padding: 0.75rem 1rem;
            font-size: 14px;
            background: #f9fafb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .ai-chat-input:focus {
            outline: none;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .ai-chat-send-btn {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: #f9fafb;
            color: #232323;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ai-chat-send-btn:hover {
            background: #232323;
            color: white;
            transform: scale(1.1);
        }

        /* Quick Questions */
        .quick-question-btn {
            background: #232323;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 11px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .quick-question-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            background: #000;
        }

        /* Product Suggestions */
        .product-suggestions {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
        }

        .product-suggestions-title {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .product-suggestions-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 8px;
        }

        .product-item {
            background: #232323;
            border-radius: 6px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-item:hover {
            background: #333;
            transform: translateX(2px);
        }

        .product-image {
            width: 100%;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 4px;
        }

        .product-name {
            font-size: 11px;
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
            line-height: 1.2;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .product-item .product-name {
            font-size: 12px;
            color: #ffffff;
            font-weight: 500;
            flex: 1;
            margin-right: 8px;
            margin-bottom: 0;
        }

        .product-item .product-price {
            font-size: 11px;
            color: #ffffff;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .product-category {
            font-size: 10px;
            color: #666;
            margin-bottom: 2px;
        }

        .product-price {
            font-size: 11px;
            color: #ffffff;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .product-image-placeholder {
            width: 100%;
            height: 60px;
            background: #f0f0f0;
            border-radius: 4px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #999;
        }

        .product-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: #ffd700;
            color: #333;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: bold;
        }

        .product-type-badge {
            position: absolute;
            top: 4px;
            left: 4px;
            background: #007bff;
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: bold;
        }

        .product-card {
            position: relative;
        }

        /* Animations */
        .ai-shake {
            animation: aiShake 0.5s infinite;
        }

        @keyframes aiShake {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-2px);
            }

            50% {
                transform: translateX(2px);
            }

            75% {
                transform: translateX(-2px);
            }

            100% {
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-3px);
            }

            60% {
                transform: translateY(-1px);
            }
        }

        .ai-typing {
            display: inline-block;
            padding: 12px 16px;
            border-radius: 18px;
            background: #fff;
            color: #333;
            font-size: 14px;
            border: 1px solid #e5e7eb;
        }

        .ai-typing::after {
            content: '';
            display: inline-block;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #232323;
            margin-left: 4px;
            animation: typing 1s infinite;
        }

        @keyframes typing {

            0%,
            60%,
            100% {
                opacity: 0;
            }

            30% {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .ai-chat-toggle-btn {
                bottom: 15px;
                left: 15px;
            }

            #hana-ai-chat-component .hana-ai-toggle-btn {
                position: fixed;
                bottom: 20px;
                left: 20px;
                z-index: 10000;
            }

            #hana-ai-chat-component .hana-ai-toggle-button {
                width: 60px;
                height: 60px;
                background: var(--hana-ai-primary);
                color: var(--hana-ai-white);
                border: none;
                box-shadow: 0 4px 20px var(--hana-ai-shadow);
                position: relative;
                animation: hanaAiPulse 2s infinite;
                transition: all 0.3s ease;
            }

            #hana-ai-chat-component .hana-ai-toggle-button:hover {
                transform: scale(1.1);
                box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
            }

            #hana-ai-chat-component .hana-ai-toggle-button i {
                font-size: 1.5rem;
            }

            #hana-ai-chat-component .hana-ai-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                width: 20px;
                height: 20px;
                background: var(--hana-ai-primary);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 10px;
                color: var(--hana-ai-white);
                font-weight: bold;
                animation: hanaAiBounce 1s infinite;
            }

            /* AI Chat Tooltip */
            #hana-ai-chat-component .hana-ai-tooltip {
                display: none;
                position: absolute;
                left: 70px;
                bottom: 0;
                background: var(--hana-ai-white);
                color: var(--hana-ai-text);
                border: 1px solid var(--hana-ai-border);
                padding: 8px 16px;
                border-radius: 8px;
                font-size: 14px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                white-space: nowrap;
                z-index: 10001;
                max-width: 200px;
            }

            #hana-ai-chat-component .hana-ai-tooltip-title {
                font-weight: 600;
                margin-bottom: 4px;
            }

            #hana-ai-chat-component .hana-ai-tooltip-subtitle {
                font-size: 12px;
                color: var(--hana-ai-text-light);
            }

            /* AI Chat Container */
            #hana-ai-chat-component .hana-ai-container {
                position: fixed;
                bottom: 100px;
                left: 20px;
                z-index: 9999;
                width: 380px;
                max-width: 90vw;
                display: none;
                border-radius: 12px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
                background: var(--hana-ai-white);
                border: 1px solid var(--hana-ai-border);
                transition: all 0.3s ease;
            }

            #hana-ai-chat-component .hana-ai-wrapper {
                display: flex;
                flex-direction: column;
                height: 500px;
            }

            /* AI Chat Header */
            #hana-ai-chat-component .hana-ai-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1rem;
                background: var(--hana-ai-primary);
                border-radius: 12px 12px 0 0;
            }

            #hana-ai-chat-component .hana-ai-header-left {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            #hana-ai-chat-component .hana-ai-avatar {
                width: 40px;
                height: 40px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #hana-ai-chat-component .hana-ai-info h6 {
                font-weight: bold;
                color: var(--hana-ai-white);
                font-size: 16px;
                margin: 0;
            }

            #hana-ai-chat-component .hana-ai-info p {
                color: rgba(255, 255, 255, 0.7);
                font-size: 12px;
                margin: 0;
            }

            #hana-ai-chat-component .hana-ai-info small {
                color: rgba(255, 255, 255, 0.5);
                font-size: 10px;
            }

            #hana-ai-chat-component .hana-ai-actions {
                display: flex;
                gap: 0.5rem;
            }

            #hana-ai-chat-component .hana-ai-btn {
                width: 32px;
                height: 32px;
                background: rgba(255, 255, 255, 0.9);
                border: none;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            #hana-ai-chat-component .hana-ai-btn:hover {
                background: var(--hana-ai-white);
                transform: scale(1.1);
            }

            /* AI Chat Messages */
            #hana-ai-chat-component .hana-ai-messages {
                flex-grow: 1;
                padding: 1rem;
                overflow-y: auto;
                background: var(--hana-ai-bg-light);
                scrollbar-width: thin;
                scrollbar-color: #c1c1c1 #f1f1f1;
            }

            #hana-ai-chat-component .hana-ai-messages::-webkit-scrollbar {
                width: 6px;
            }

            #hana-ai-chat-component .hana-ai-messages::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }

            #hana-ai-chat-component .hana-ai-messages::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 3px;
            }

            #hana-ai-chat-component .hana-ai-messages::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }

            /* AI Chat Input */
            #hana-ai-chat-component .hana-ai-input-area {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 1rem;
                background: var(--hana-ai-white);
                border-radius: 0 0 12px 12px;
                border-top: 1px solid var(--hana-ai-border);
            }

            #hana-ai-chat-component .hana-ai-input {
                flex-grow: 1;
                border: none;
                border-radius: 25px;
                padding: 0.75rem 1rem;
                font-size: 14px;
                background: var(--hana-ai-secondary);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
            }

            #hana-ai-chat-component .hana-ai-input:focus {
                outline: none;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
                background: var(--hana-ai-white);
            }

            #hana-ai-chat-component .hana-ai-send-btn {
                width: 40px;
                height: 40px;
                border: none;
                border-radius: 50%;
                background: var(--hana-ai-secondary);
                color: var(--hana-ai-primary);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            #hana-ai-chat-component .hana-ai-send-btn:hover {
                background: var(--hana-ai-primary);
                color: var(--hana-ai-white);
                transform: scale(1.1);
            }

            /* Quick Questions */
            #hana-ai-chat-component .hana-ai-quick-btn {
                background: var(--hana-ai-primary);
                color: var(--hana-ai-white);
                border: none;
                padding: 6px 12px;
                border-radius: 15px;
                font-size: 11px;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            <script> // Load chat history từ localStorage

            function loadChatHistory() {
                const history=localStorage.getItem('ai_chat_history');

                if (history) {
                    try {
                        const chatHistory=JSON.parse(history);

                        if (chatHistory.length > 0) {
                            chatHistory.forEach(item=> {
                                    // Hiển thị tin nhắn người dùng
                                    appendAiMessage(item.user_message, true);

                                    // Hiển thị tin nhắn AI
                                    appendAiMessage(item.ai_response, false);
                                });
                        }
                    }

                    catch (e) {
                        console.error('Error loading chat history:', e);
                        localStorage.removeItem('ai_chat_history');
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                    const aiChatToggleBtn=document.getElementById('ai-chat-toggle-btn');
                    const aiChatContainer=document.getElementById('ai-chat-container');
                    const aiChatMinimizeBtn=document.getElementById('ai-chat-minimize-btn');
                    const aiChatClearBtn=document.getElementById('ai-chat-clear-btn');
                    const aiChatInput=document.getElementById('ai-chat-input');
                    const aiChatMessages=document.getElementById('ai-chat-messages');
                    const aiChatSendBtn=document.getElementById('ai-chat-send-btn');
                    const aiChatTooltip=document.getElementById('ai-chat-tooltip');

                    /* Product Suggestions */
                    #hana-ai-chat-component .hana-ai-product-suggestions {
                        margin-top: 12px;
                        padding-top: 12px;
                        border-top: 1px solid var(--hana-ai-border);
                    }

                    // Load chat history khi khởi tạo
                    loadChatHistory();

                    // Hiển thị tooltip khi hover
                    aiChatToggleBtn.addEventListener('mouseenter', function() {
                            aiChatTooltip.style.display='block';
                        });

                    #hana-ai-chat-component .hana-ai-product-grid {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 8px;
                    }

                    #hana-ai-chat-component .hana-ai-product-card {
                        background: #f8f9fa;
                        border: 1px solid var(--hana-ai-border);
                        border-radius: 8px;
                        padding: 8px;
                        min-width: 120px;
                        max-width: 150px;
                        cursor: pointer;
                        transition: all 0.3s ease;
                    }

                    #hana-ai-chat-component .hana-ai-product-card:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    }

                    // Xóa lịch sử chat
                    aiChatClearBtn.onclick=()=> {
                        if (confirm('Bạn có chắc muốn xóa toàn bộ lịch sử chat?')) {
                            // Xóa localStorage
                            localStorage.removeItem('ai_chat_history');

                            // Xóa server session
                            fetch('/client/ai-chat/clear', {

                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }

                            }) .then(res=> res.json()) .then(data=> {
                                if (data.success) {
                                    aiChatMessages.innerHTML=` <div class="d-flex mb-3 justify-content-start" > <div style="max-width: 80%; display: flex; align-items: flex-end; gap: 8px;" > <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;" > <i class="fas fa-robot text-white" style="font-size: 14px;" ></i> </div> <div style="display: flex; flex-direction: column; align-items: flex-start;" > <span style="display: inline-block; padding: 12px 16px; border-radius: 18px; font-size: 14px; background: #f8f9fa; color: #333; box-shadow: 0 2px 8px rgba(0,0,0,0.1); word-break: break-word; border: 1px solid #e9ecef;" > 👋 Xin chào ! Tôi là Hana AI Assistant, chuyên gia tư vấn kính mắt. Tôi có thể giúp bạn: <br>• Chọn kính phù hợp với khuôn mặt <br>• Tư vấn màu sắc và kiểu dáng <br>• Giải đáp về phong thủy kính mắt <br>• Thông tin về các loại kính <br><br>Hãy hỏi tôi bất cứ điều gì về kính mắt nhé ! 😊 </span> <span style="font-size:11px;color:#999;margin-top:4px;" >Vừa xong</span> </div> </div> </div> `;
                                }
                            });
                    }
                }

                ;

                // Reset giới hạn chat (chỉ để test)
                const aiChatResetLimitBtn=document.getElementById('ai-chat-reset-limit-btn');

                aiChatResetLimitBtn.onclick=()=> {
                    if (confirm('Bạn có chắc muốn reset giới hạn chat? (Chỉ để test)')) {

                        // Reset rate limit
                        fetch('/client/ai-chat/reset-limit', {

                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }

                        }) .then(res=> res.json()) .then(data=> {
                            if (data.success) {
                                appendAiMessage('✅ Đã reset giới hạn chat. Bạn có thể chat lại!', false);
                                aiChatResetLimitBtn.style.display='none';
                            }
                        });
                }
            }

            ;

            // Event delegation cho product items
            document.addEventListener('click', function(e) {
                    if (e.target.closest('.product-item')) {
                        const productItem=e.target.closest('.product-item');
                        const url=productItem.dataset.productUrl;
                        const name=productItem.dataset.productName;


                        openProduct(url, name);
                    }
                });

            // Keyboard support cho product items
            document.addEventListener('keydown', function(e) {
                    if (e.target.classList.contains('product-item')) {
                        if (e.key==='Enter' || e.key===' ') {
                            e.preventDefault();
                            const url=e.target.dataset.productUrl;
                            const name=e.target.dataset.productName;
                            openProduct(url, name);
                        }
                    }
                });

            // Gửi tin nhắn
            function sendAiMessage() {
                const message=aiChatInput.value.trim();
                if ( !message || isTyping) return;

                // Hiển thị tin nhắn người dùng
                appendAiMessage(message, true);
                aiChatInput.value='';

                // Hiển thị typing indicator
                showTypingIndicator();

                // Gọi API AI
                fetch('/client/ai-chat/send', {

                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }

                    ,
                    body: JSON.stringify({
                        message: message
                    })

            }) .then(res=> res.json()) .then(data=> {
                hideTypingIndicator();

                if (data.success) {
                    // Thêm thông tin về filter giá nếu có
                    let responseMessage=data.ai_response;

                    if (data.price_filter && data.products_count !==undefined) {
                        responseMessage +=`\n\n📊 Tìm thấy ${data.products_count} sản phẩm phù hợp với yêu cầu giá của bạn.`;
                    }

                    appendAiMessage(responseMessage, false, data.suggested_products);

                    // Lưu chat history vào localStorage
                    if (data.chat_history) {
                        localStorage.setItem('ai_chat_history', JSON.stringify(data.chat_history));
                    }
                }

                else {
                    if (data.require_login) {
                        appendAiMessage('🔐 Vui lòng đăng nhập để sử dụng AI Chat. <a href="/client/login" style="color: #007bff; text-decoration: underline;">Đăng nhập ngay</a>', false);
                    }

                    else if (data.message && data.message.includes('vượt quá giới hạn')) {
                        appendAiMessage(`⏰ ${data.message}`, false);
                    }

                    else {
                        appendAiMessage('Xin lỗi, tôi gặp sự cố. Vui lòng thử lại sau.', false);
                    }
                }

                // Hiển thị tin nhắn
                function appendAiMessage(message, isUser, suggestedProducts=null) {
                    const div=document.createElement('div');
                    const now=new Date();

                    const time=now.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                if (isUser) {
                    div.className='d-flex mb-3 justify-content-end';
                    div.innerHTML=` <div style="max-width: 80%; display: flex; flex-direction: column; align-items: flex-end;" > <span style="display: inline-block; padding: 12px 16px; border-radius: 18px; font-size: 14px; background: #232323; color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); word-break: break-word;" > ${message} </span> <span style="font-size:11px;color:#999;margin-top:4px;" >${time}</span> </div> `;
                }

                else {
                    let productsHtml='';

                    if (suggestedProducts && suggestedProducts.length > 0) {

                        productsHtml=` <div class="product-suggestions" > <div class="product-suggestions-title" >🛍️ Sản phẩm gợi ý:</div> <div class="product-suggestions-list" > ${suggestedProducts.map((product, index) => `
 <div class="product-item"
                        data-product-url="${product.url}"
                        data-product-name="${product.name}"
                        tabindex="0"
                        role="button"
                        title="Xem chi tiết ${product.name}" > <span class="product-name" >${product.name}</span> <span class="product-price" >${product.price}</span> </div> `).join('')
                }

                </div> </div> `;
            }

            div.className='d-flex mb-3 justify-content-start';
            div.innerHTML=` <div style="max-width: 80%; display: flex; align-items: flex-end; gap: 8px;" > <div style="width: 32px; height: 32px; background: #232323; border-radius: 50%; display: flex; align-items: center; justify-content: center;" > <i class="fas fa-robot text-white" style="font-size: 14px;" ></i> </div> <div style="display: flex; flex-direction: column; align-items: flex-start;" > <span style="display: inline-block; padding: 12px 16px; border-radius: 18px; font-size: 14px; background: #fff; color: #333; box-shadow: 0 2px 8px rgba(0,0,0,0.08); word-break: break-word; border: 1px solid #e5e7eb;" > ${message} ${productsHtml} </span> <span style="font-size:11px;color:#999;margin-top:4px;" >${time}</span> </div> </div> `;
        }

        aiChatMessages.appendChild(div);
        aiChatMessages.scrollTop=aiChatMessages.scrollHeight;
        }

        // Hiển thị typing indicator
        function showTypingIndicator() {
            isTyping=true;
            const typingDiv=document.createElement('div');
            typingDiv.id='typing-indicator';
            typingDiv.className='d-flex mb-3 justify-content-start';
            typingDiv.innerHTML=` <div style="max-width: 80%; display: flex; align-items: flex-end; gap: 8px;" > <div style="width: 32px; height: 32px; background: #232323; border-radius: 50%; display: flex; align-items: center; justify-content: center;" > <i class="fas fa-robot text-white" style="font-size: 14px;" ></i> </div> <div style="display: flex; flex-direction: column; align-items: flex-start;" > <span class="hana-ai-typing" >Hana AI đang trả lời...</span> </div> </div> `;
            aiChatMessages.appendChild(typingDiv);
            aiChatMessages.scrollTop=aiChatMessages.scrollHeight;
        }

        // Ẩn typing indicator
        function hideTypingIndicator() {
            isTyping=false;
            const typingIndicator=document.getElementById('typing-indicator');

            if (typingIndicator) {
                typingIndicator.remove();
            }
        }

        // Function để mở sản phẩm
        function openProduct(url, productName) {
            try {


                if (url && url !=='#' && url !=='undefined') {
                    // Thêm tracking cho analytics


                    // Mở sản phẩm trong tab mới
                    const newWindow=window.open(url, '_blank');

                    if (newWindow) {
                        // Hiển thị thông báo nhỏ
                        showProductNotification(productName);
                    }

                    else {
                        // Nếu popup bị block, thử mở trong tab hiện tại
                        window.location.href=url;
                    }
                }

                else {

                    alert('Không thể mở sản phẩm này. Vui lòng thử lại sau.');
                }
            }

            catch (error) {
                console.error('Error in openProduct:', error);
                alert('Có lỗi xảy ra khi mở sản phẩm. Vui lòng thử lại.');
            }
        }

        // Hiển thị thông báo khi click sản phẩm
        function showProductNotification(productName) {
            const notification=document.createElement('div');
            notification.style.cssText=` position: fixed;
            top: 20px;
            right: 20px;
            background: #232323;
            color: white;
            padding: 12px 16px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            font-size: 14px;
            max-width: 300px;
            word-wrap: break-word;
            font-size: 14px;
            z-index: 10002;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease;
            `;
            notification.textContent=`Đã mở sản phẩm: ${productName}`;

            document.body.appendChild(notification);

            setTimeout(()=> {
                    notification.style.animation='slideOut 0.3s ease';
                    setTimeout(()=> notification.remove(), 300);
                }

                , 2000);
        }

        // Event listeners
        aiChatSendBtn.addEventListener('click', sendAiMessage);

        aiChatInput.addEventListener('keydown', e=> {
                if (e.key==='Enter') {
                    e.preventDefault();
                    sendAiMessage();
                }
            });

        // Load lịch sử chat khi mở
        function loadAiChatHistory() {
            fetch('/client/ai-chat/history') .then(res=> res.json()) .then(data=> {
                    if (data.success && data.history.length > 0) {
                        // Xóa tin nhắn chào mừng mặc định
                        aiChatMessages.innerHTML='';

                        // Hiển thị lịch sử chat
                        data.history.forEach(item=> {
                                appendAiMessage(item.user_message, true);
                                appendAiMessage(item.ai_response, false);
                            });
                    }

                }) .catch(error=> {});

            // Load lịch sử chat khi mở
            function loadAiChatHistory() {
                fetch('/client/ai-chat/history') .then(res=> res.json()) .then(data=> {
                        if (data.success && data.history.length > 0) {
                            // Xóa tin nhắn chào mừng mặc định
                            aiChatMessages.innerHTML='';

                            // Hiển thị lịch sử chat
                            data.history.forEach(item=> {
                                    appendAiMessage(item.user_message, true);
                                    appendAiMessage(item.ai_response, false);
                                });
                        }

                    }) .catch(error=> {
                        console.log('Không thể tải lịch sử chat');
                    });
            }

            // Load lịch sử khi mở chat
            aiChatToggleBtn.addEventListener('click', loadAiChatHistory);

            // Quick questions functionality
            document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('hana-ai-quick-btn')) {
                        const question=e.target.getAttribute('data-question');
                        aiChatInput.value=question;
                        sendAiMessage();
                    }
                });
        });
        </script>@endif
