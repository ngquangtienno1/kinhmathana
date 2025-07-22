<!-- Nút mở chat -->
<div id="chat-toggle-btn" style="position: fixed; bottom: 20px; right: 20px; z-index: 10000;">
    <button class="btn rounded-circle shadow d-flex align-items-center justify-content-center"
        style="width: 50px; height: 50px; background: #232946; color: #fff; border: none; box-shadow: 0 4px 16px #0002; position: relative;">
        <i class="fa-regular fa-comments fs-5"></i>
    </button>
    <div id="chat-tooltip"
        style="display:none; position:absolute; right:60px; left:auto; bottom:0; background:#fff; color:#232946; border:1px solid #e5e7eb; padding:7px 16px; border-radius:8px; font-size:14px; box-shadow:0 2px 8px #0001; white-space:nowrap; z-index:10001;">
        Bạn có tin nhắn mới từ CSKH!</div>
</div>

<!-- Khung chat kiểu Messenger -->
<div id="client-support-chat"
    style="position: fixed; bottom: 80px; right: 20px; z-index: 9999; width: 340px; max-width: 95%; display: none; border-radius: 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.18); background: rgba(60,60,60,0.15); backdrop-filter: blur(8px);">
    <div class="d-flex flex-column" style="height: 480px;">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between px-3 py-2"
            style="background: linear-gradient(135deg, #3b82f6, #60a5fa); border-radius: 18px 18px 0 0;">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ auth()->check() && auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png' }}"
                    alt="Khách" style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid #fff;">
                <div>
                    <div class="fw-bold text-white" style="font-size: 15px;">
                        {{ auth()->check() ? auth()->user()->name : 'Khách' }}</div>
                    <div class="text-white-50" style="font-size: 12px;">Bạn đang chat với CSKH</div>
                </div>
            </div>
            <button id="chat-minimize-btn" class="btn btn-light rounded-circle shadow-sm"
                style="width: 30px; height: 30px; padding: 0;">
                <i class="fa-solid fa-chevron-down fs-6"></i>
            </button>
        </div>
        <!-- Messages -->
        <div id="chat-messages" class="flex-grow-1 px-2 py-3"
            style="overflow-y: auto; background: rgba(255,255,255,0.7);">
            <!-- Tin nhắn sẽ được append ở đây -->
        </div>
        <!-- Input -->
        <div class="d-flex align-items-center gap-2 px-2 py-2"
            style="background: rgba(255,255,255,0.95); border-radius: 0 0 18px 18px;">
            <input class="form-control border-0 rounded-pill px-3 py-2" type="text" id="chat-input" placeholder="Aa"
                autocomplete="off" style="font-size: 15px; background: #f1f5f9;">
            <button class="btn btn-link p-0 send-btn" id="chat-send-btn" style="color: #3b82f6;">
                <i class="fa-solid fa-paper-plane fs-4"></i>
            </button>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    // Toggle chat với animation
    const chatToggleBtn = document.getElementById('chat-toggle-btn');
    const chatContainer = document.getElementById('client-support-chat');
    const chatMinimizeBtn = document.getElementById('chat-minimize-btn');

    // Thêm CSS rung cho nút chat
    const shakeStyle = document.createElement('style');
    shakeStyle.innerHTML = `
    @keyframes shake {
      0% { transform: translate(1px, 1px) rotate(0deg); }
      10% { transform: translate(-1px, -2px) rotate(-1deg); }
      20% { transform: translate(-3px, 0px) rotate(1deg); }
      30% { transform: translate(3px, 2px) rotate(0deg); }
      40% { transform: translate(1px, -1px) rotate(1deg); }
      50% { transform: translate(-1px, 2px) rotate(-1deg); }
      60% { transform: translate(-3px, 1px) rotate(0deg); }
      70% { transform: translate(3px, 1px) rotate(-1deg); }
      80% { transform: translate(-1px, -1px) rotate(1deg); }
      90% { transform: translate(1px, 2px) rotate(0deg); }
      100% { transform: translate(1px, -2px) rotate(-1deg); }
    }
    .shake {
      animation: shake 0.5s infinite;
    }
    `;
    document.head.appendChild(shakeStyle);

    let isChatOpen = false;
    let tooltipTimeout = null;

    function showChatTooltip() {
        const tooltip = document.getElementById('chat-tooltip');
        if (!tooltip) return;
        tooltip.style.display = 'block';
        if (tooltipTimeout) clearTimeout(tooltipTimeout);
        tooltipTimeout = setTimeout(() => {
            tooltip.style.display = 'none';
        }, 5000);
    }

    chatToggleBtn.onclick = () => {
        chatContainer.style.display = 'block';
        setTimeout(() => {
            chatContainer.style.opacity = '1';
            chatContainer.style.transform = 'scale(1)';
        }, 10);
        chatToggleBtn.style.display = 'none';
        isChatOpen = true;
        chatToggleBtn.classList.remove('shake'); // Dừng rung khi mở chat
        // Ẩn tooltip khi mở chat
        const tooltip = document.getElementById('chat-tooltip');
        if (tooltip) tooltip.style.display = 'none';
    };
    chatMinimizeBtn.onclick = () => {
        chatContainer.style.opacity = '0';
        chatContainer.style.transform = 'scale(0.9)';
        setTimeout(() => {
            chatContainer.style.display = 'none';
            chatToggleBtn.style.display = 'block';
        }, 300);
        isChatOpen = false;
    };

    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    const sendBtn = document.getElementById('chat-send-btn');
    const userId = {{ auth()->check() ? auth()->id() : 0 }};
    const adminId = 1;

    function appendMessage(msg, isMe) {
        const div = document.createElement('div');

        function formatTime(str) {
            if (!str) return '';
            const d = new Date(str);
            const now = new Date();
            const isToday = d.toDateString() === now.toDateString();
            return isToday ? d.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            }) : d.toLocaleDateString() + ' ' + d.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
        let time = msg.created_at ? formatTime(msg.created_at) : '';
        div.className = `d-flex mb-2 ${isMe ? 'justify-content-end' : 'justify-content-start'}`;
        div.innerHTML = `
            <div style="
                max-width: 75%;
                display: flex;
                align-items: flex-end;
                gap: 6px;
            ">
                ${!isMe ? `<img src='{{ auth()->check() && auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png' }}' style='width:22px;height:22px;border-radius:50%;border:1.5px solid #fff;box-shadow:0 1px 2px #0001;'/>` : ''}
                <div style="display: flex; flex-direction: column; align-items: ${isMe ? 'flex-end' : 'flex-start'};">
                    <span style="display: inline-block; padding: 8px 14px; border-radius: 18px; font-size: 15px; background: ${isMe ? 'linear-gradient(135deg, #3b82f6, #60a5fa)' : '#232946'}; color: #fff; box-shadow: 0 1px 4px rgba(60,60,60,0.04); word-break: break-word;">${msg.message}</span>
                    <span style="font-size:11px;color:#aaa;margin-top:2px;${isMe ? 'text-align:right;' : 'text-align:left;'}">${time}</span>
                </div>
            </div>
        `;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Load lịch sử chat khi mở chat
    function loadHistory() {
        fetch('/client/chat/conversation/' + userId)
            .then(res => res.json())
            .then(data => {
                chatMessages.innerHTML = '';
                if (data.messages?.length > 0) {
                    data.messages.forEach(msg => appendMessage(msg, msg.from_id == userId));
                }
            });
    }

    document.addEventListener('DOMContentLoaded', loadHistory);

    function sendMessage(msg) {
        const message = msg || chatInput.value.trim();
        if (!message) return;
        fetch('/client/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                to_id: adminId,
                message
            })
        }).then(res => res.json()).then(() => {
            appendMessage({
                message
            }, true);
        });
        chatInput.value = '';
    }

    sendBtn.addEventListener('click', e => {
        e.preventDefault();
        sendMessage();
    });

    chatInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });

    const pusher = new Pusher('470ba5e93dce15022f9e', {
        cluster: 'ap1',
        forceTLS: true
    });
    const channel = pusher.subscribe('chat-user-' + userId);
    channel.bind('chat-message', data => {
        appendMessage(data, data.from_id == userId);
        // Nếu là tin nhắn từ admin và chat chưa mở thì rung nút chat + hiện tooltip
        if (data.from_id == adminId && !isChatOpen) {
            chatToggleBtn.classList.add('shake');
            showChatTooltip();
        }
    });
</script>
