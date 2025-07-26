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
                            Giới hạn: 20 tin nhắn/giờ
                        @else
                            Giới hạn: 5 tin nhắn/giờ
                        @endif
                    </small>
                </div>
            </div>
            <div class="ai-chat-actions">
                <button id="ai-chat-clear-btn" class="ai-chat-btn" title="Xóa lịch sử">
                    <i class="fas fa-trash"></i>
                </button>
                <button id="ai-chat-minimize-btn" class="ai-chat-btn">
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <!-- Messages -->
        <div id="ai-chat-messages" class="ai-chat-messages">
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
                            👋 Xin chào! Tôi là Hana AI Assistant, chuyên gia tư vấn kính mắt. Tôi có thể giúp bạn:
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
                            <button class="quick-question-btn" data-question="Tư vấn chọn kính cho khuôn mặt tròn">Khuôn mặt tròn</button>
                            <button class="quick-question-btn" data-question="Kính mắt phong thủy có tác dụng gì?">Phong thủy</button>
                            <button class="quick-question-btn" data-question="Giá kính mắt khoảng bao nhiêu?">Giá cả</button>
                            <button class="quick-question-btn" data-question="Cách bảo quản kính mắt">Bảo quản</button>
                            <button class="quick-question-btn" data-question="Địa chỉ cửa hàng ở đâu?">Địa chỉ</button>
                            <button class="quick-question-btn" data-question="Hotline liên hệ là gì?">Hotline</button>
                            <button class="quick-question-btn" data-question="Có những loại kính nào?">Sản phẩm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="ai-chat-input-area">
            <input class="ai-chat-input" type="text" id="ai-chat-input"
                placeholder="Nhập câu hỏi về kính mắt..." autocomplete="off">
            <button class="ai-chat-send-btn" id="ai-chat-send-btn">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
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
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
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
        background: rgba(255,255,255,0.1);
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
        color: rgba(255,255,255,0.7);
        font-size: 12px;
        margin: 0;
    }

    .ai-chat-info small {
        color: rgba(255,255,255,0.5);
        font-size: 10px;
    }

    .ai-chat-actions {
        display: flex;
        gap: 0.5rem;
    }

    .ai-chat-btn {
        width: 32px;
        height: 32px;
        background: rgba(255,255,255,0.9);
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
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .ai-chat-input:focus {
        outline: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
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

    .product-suggestions-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .product-card {
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 8px;
        min-width: 120px;
        max-width: 150px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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

    .product-category {
        font-size: 10px;
        color: #666;
        margin-bottom: 2px;
    }

    .product-price {
        font-size: 11px;
        color: #232323;
        font-weight: 600;
    }

    /* Animations */
    .ai-shake {
        animation: aiShake 0.5s infinite;
    }

    @keyframes aiShake {
        0% { transform: translateX(0); }
        25% { transform: translateX(-2px); }
        50% { transform: translateX(2px); }
        75% { transform: translateX(-2px); }
        100% { transform: translateX(0); }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-3px); }
        60% { transform: translateY(-1px); }
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
        0%, 60%, 100% { opacity: 0; }
        30% { opacity: 1; }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .ai-chat-toggle-btn {
            bottom: 15px;
            left: 15px;
        }

        .ai-toggle-button {
            width: 55px;
            height: 55px;
        }

        .ai-toggle-button i {
            font-size: 1.3rem;
        }

        .ai-badge {
            width: 18px;
            height: 18px;
            font-size: 9px;
        }

        .ai-chat-container {
            bottom: 80px;
            left: 15px;
            right: 15px;
            width: auto;
            max-width: none;
        }

        .ai-chat-wrapper {
            height: 450px;
        }

        .ai-chat-tooltip {
            left: 60px;
            max-width: 180px;
            font-size: 13px;
        }

        .tooltip-title {
            font-size: 13px;
        }

        .tooltip-subtitle {
            font-size: 11px;
        }
    }

    @media (max-width: 480px) {
        .ai-chat-toggle-btn {
            bottom: 10px;
            left: 10px;
        }

        .ai-toggle-button {
            width: 50px;
            height: 50px;
        }

        .ai-toggle-button i {
            font-size: 1.2rem;
        }

        .ai-badge {
            width: 16px;
            height: 16px;
            font-size: 8px;
        }

        .ai-chat-container {
            bottom: 70px;
            left: 10px;
            right: 10px;
        }

        .ai-chat-wrapper {
            height: 400px;
        }

        .ai-chat-header {
            padding: 0.75rem;
        }

        .ai-chat-avatar {
            width: 35px;
            height: 35px;
        }

        .ai-chat-info h6 {
            font-size: 14px;
        }

        .ai-chat-info p {
            font-size: 11px;
        }

        .ai-chat-info small {
            font-size: 9px;
        }

        .ai-chat-messages {
            padding: 0.75rem;
        }

        .ai-chat-input-area {
            padding: 0.75rem;
        }

        .ai-chat-input {
            padding: 0.5rem 0.75rem;
            font-size: 13px;
        }

        .ai-chat-send-btn {
            width: 35px;
            height: 35px;
        }

        .quick-question-btn {
            padding: 5px 10px;
            font-size: 10px;
        }

        .product-card {
            min-width: 100px;
            max-width: 120px;
            padding: 6px;
        }

        .product-image {
            height: 50px;
        }

        .product-name {
            font-size: 10px;
        }

        .product-category {
            font-size: 9px;
        }

        .product-price {
            font-size: 10px;
        }

        .ai-chat-tooltip {
            left: 55px;
            max-width: 160px;
            font-size: 12px;
            padding: 6px 12px;
        }
    }

    @media (max-width: 360px) {
        .ai-chat-container {
            bottom: 60px;
            left: 5px;
            right: 5px;
        }

        .ai-chat-wrapper {
            height: 350px;
        }

        .ai-chat-header {
            padding: 0.5rem;
        }

        .ai-chat-avatar {
            width: 30px;
            height: 30px;
        }

        .ai-chat-info h6 {
            font-size: 13px;
        }

        .ai-chat-info p {
            font-size: 10px;
        }

        .ai-chat-messages {
            padding: 0.5rem;
        }

        .ai-chat-input-area {
            padding: 0.5rem;
        }

        .product-card {
            min-width: 90px;
            max-width: 110px;
        }
    }

    /* Landscape orientation for mobile */
    @media (max-height: 500px) and (orientation: landscape) {
        .ai-chat-container {
            bottom: 10px;
            top: 10px;
            height: calc(100vh - 20px);
        }

        .ai-chat-wrapper {
            height: 100%;
        }
    }

    /* High DPI displays */
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
        .ai-toggle-button {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .ai-chat-container {
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .ai-chat-container {
            background: #1a1a1a;
            border-color: #333;
        }

        .ai-chat-messages {
            background: #0f0f0f;
        }

        .ai-chat-input {
            background: #2a2a2a;
            color: #fff;
        }

        .ai-chat-input:focus {
            background: #333;
        }

        .ai-chat-send-btn {
            background: #2a2a2a;
            color: #fff;
        }

        .product-card {
            background: #2a2a2a;
            border-color: #333;
        }

        .product-name {
            color: #fff;
        }

        .product-category {
            color: #ccc;
        }

        .ai-chat-tooltip {
            background: #1a1a1a;
            border-color: #333;
            color: #fff;
        }

        .tooltip-subtitle {
            color: #ccc;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const aiChatToggleBtn = document.getElementById('ai-chat-toggle-btn');
    const aiChatContainer = document.getElementById('ai-chat-container');
    const aiChatMinimizeBtn = document.getElementById('ai-chat-minimize-btn');
    const aiChatClearBtn = document.getElementById('ai-chat-clear-btn');
    const aiChatInput = document.getElementById('ai-chat-input');
    const aiChatMessages = document.getElementById('ai-chat-messages');
    const aiChatSendBtn = document.getElementById('ai-chat-send-btn');
    const aiChatTooltip = document.getElementById('ai-chat-tooltip');

    let isAiChatOpen = false;
    let isTyping = false;

    // Hiển thị tooltip khi hover
    aiChatToggleBtn.addEventListener('mouseenter', function() {
        aiChatTooltip.style.display = 'block';
    });

    aiChatToggleBtn.addEventListener('mouseleave', function() {
        aiChatTooltip.style.display = 'none';
    });

    // Mở/đóng AI chat
    aiChatToggleBtn.onclick = () => {
        aiChatContainer.style.display = 'block';
        setTimeout(() => {
            aiChatContainer.style.opacity = '1';
            aiChatContainer.style.transform = 'scale(1)';
        }, 10);
        aiChatToggleBtn.style.display = 'none';
        isAiChatOpen = true;
        aiChatInput.focus();
    };

    aiChatMinimizeBtn.onclick = () => {
        aiChatContainer.style.opacity = '0';
        aiChatContainer.style.transform = 'scale(0.9)';
        setTimeout(() => {
            aiChatContainer.style.display = 'none';
            aiChatToggleBtn.style.display = 'block';
        }, 300);
        isAiChatOpen = false;
    };

    // Xóa lịch sử chat
    aiChatClearBtn.onclick = () => {
        if (confirm('Bạn có chắc muốn xóa toàn bộ lịch sử chat?')) {
            fetch('/client/ai-chat/clear', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    aiChatMessages.innerHTML = `
                        <div class="d-flex mb-3 justify-content-start">
                            <div style="max-width: 80%; display: flex; align-items: flex-end; gap: 8px;">
                                <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-robot text-white" style="font-size: 14px;"></i>
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                    <span style="display: inline-block; padding: 12px 16px; border-radius: 18px; font-size: 14px; background: #f8f9fa; color: #333; box-shadow: 0 2px 8px rgba(0,0,0,0.1); word-break: break-word; border: 1px solid #e9ecef;">
                                        👋 Xin chào! Tôi là Hana AI Assistant, chuyên gia tư vấn kính mắt. Tôi có thể giúp bạn:
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
                    `;
                }
            });
        }
    };

    // Gửi tin nhắn
    function sendAiMessage() {
        const message = aiChatInput.value.trim();
        if (!message || isTyping) return;

        // Hiển thị tin nhắn người dùng
        appendAiMessage(message, true);
        aiChatInput.value = '';

        // Hiển thị typing indicator
        showTypingIndicator();

        // Gọi API AI
        fetch('/client/ai-chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(res => res.json())
        .then(data => {
            hideTypingIndicator();
            if (data.success) {
                appendAiMessage(data.ai_response, false, data.suggested_products);
            } else {
                appendAiMessage('Xin lỗi, tôi gặp sự cố. Vui lòng thử lại sau.', false);
            }
        })
        .catch(error => {
            hideTypingIndicator();
            appendAiMessage('Xin lỗi, có lỗi kết nối. Vui lòng thử lại sau.', false);
        });
    }

    // Hiển thị tin nhắn
    function appendAiMessage(message, isUser, suggestedProducts = null) {
        const div = document.createElement('div');
        const now = new Date();
        const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        if (isUser) {
            div.className = 'd-flex mb-3 justify-content-end';
            div.innerHTML = `
                <div style="max-width: 80%; display: flex; flex-direction: column; align-items: flex-end;">
                    <span style="display: inline-block; padding: 12px 16px; border-radius: 18px; font-size: 14px; background: #232323; color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); word-break: break-word;">
                        ${message}
                    </span>
                    <span style="font-size:11px;color:#999;margin-top:4px;">${time}</span>
                </div>
            `;
        } else {
            let productsHtml = '';
            if (suggestedProducts && suggestedProducts.length > 0) {
                productsHtml = `
                    <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #e5e7eb;">
                        <div style="font-size: 12px; color: #666; margin-bottom: 8px; font-weight: 600;">🛍️ Sản phẩm gợi ý:</div>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            ${suggestedProducts.map(product => `
                                <div style="background: #f8f9fa; border: 1px solid #e5e7eb; border-radius: 8px; padding: 8px; min-width: 120px; max-width: 150px; cursor: pointer;" onclick="window.open('${product.url}', '_blank')">
                                    ${product.image ? `<img src="${product.image}" alt="${product.name}" style="width: 100%; height: 60px; object-fit: cover; border-radius: 4px; margin-bottom: 4px;">` : ''}
                                    <div style="font-size: 11px; font-weight: 600; color: #333; margin-bottom: 2px; line-height: 1.2;">${product.name}</div>
                                    <div style="font-size: 10px; color: #666; margin-bottom: 2px;">${product.category}</div>
                                    <div style="font-size: 11px; color: #232323; font-weight: 600;">${product.price}</div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }

            div.className = 'd-flex mb-3 justify-content-start';
            div.innerHTML = `
                <div style="max-width: 80%; display: flex; align-items: flex-end; gap: 8px;">
                    <div style="width: 32px; height: 32px; background: #232323; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-robot text-white" style="font-size: 14px;"></i>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-start;">
                        <span style="display: inline-block; padding: 12px 16px; border-radius: 18px; font-size: 14px; background: #fff; color: #333; box-shadow: 0 2px 8px rgba(0,0,0,0.08); word-break: break-word; border: 1px solid #e5e7eb;">
                            ${message}
                            ${productsHtml}
                        </span>
                        <span style="font-size:11px;color:#999;margin-top:4px;">${time}</span>
                    </div>
                </div>
            `;
        }

        aiChatMessages.appendChild(div);
        aiChatMessages.scrollTop = aiChatMessages.scrollHeight;
    }

    // Hiển thị typing indicator
    function showTypingIndicator() {
        isTyping = true;
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-indicator';
        typingDiv.className = 'd-flex mb-3 justify-content-start';
        typingDiv.innerHTML = `
            <div style="max-width: 80%; display: flex; align-items: flex-end; gap: 8px;">
                <div style="width: 32px; height: 32px; background: #232323; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-robot text-white" style="font-size: 14px;"></i>
                </div>
                <div style="display: flex; flex-direction: column; align-items: flex-start;">
                    <span class="ai-typing">Hana AI đang trả lời...</span>
                </div>
            </div>
        `;
        aiChatMessages.appendChild(typingDiv);
        aiChatMessages.scrollTop = aiChatMessages.scrollHeight;
    }

    // Ẩn typing indicator
    function hideTypingIndicator() {
        isTyping = false;
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    // Event listeners
    aiChatSendBtn.addEventListener('click', sendAiMessage);

    aiChatInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendAiMessage();
        }
    });

    // Load lịch sử chat khi mở
    function loadAiChatHistory() {
        fetch('/client/ai-chat/history')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.history.length > 0) {
                    // Xóa tin nhắn chào mừng mặc định
                    aiChatMessages.innerHTML = '';

                    // Hiển thị lịch sử chat
                    data.history.forEach(item => {
                        appendAiMessage(item.user_message, true);
                        appendAiMessage(item.ai_response, false);
                    });
                }
            })
            .catch(error => {
                console.log('Không thể tải lịch sử chat');
            });
    }

        // Load lịch sử khi mở chat
    aiChatToggleBtn.addEventListener('click', loadAiChatHistory);

    // Quick questions functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('quick-question-btn')) {
            const question = e.target.getAttribute('data-question');
            aiChatInput.value = question;
            sendAiMessage();
        }
    });
});
</script>
@endif
