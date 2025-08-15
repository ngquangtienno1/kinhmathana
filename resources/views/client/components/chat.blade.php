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
        <div class="d-flex align-items-center px-3 py-2"
            style="background: rgba(255,255,255,0.95); border-radius: 0 0 18px 18px;">
            <div class="position-relative flex-grow-1 me-2">
                <input class="form-control border-0 rounded-pill px-3 py-2" type="text" id="chat-input"
                    placeholder="Aa" autocomplete="off" style="font-size: 15px; background: #f1f5f9;">
                <div id="emoji-picker-container"
                    style="position: absolute; bottom: 100%; left: 0; z-index: 1000; display: none;">
                </div>
            </div>
            <div class="d-flex align-items-center" style="gap: 4px;">
                <button class="btn btn-link p-0" type="button" id="emoji-btn"
                    style="color: #6b7280; width: 24px; height: 24px; border-radius: 50%; transition: all 0.2s; display: flex; align-items: center; justify-content: center;"
                    title="Chọn emoji">
                    <i class="fa-regular fa-face-smile" style="font-size: 14px; display: block; line-height: 1;"></i>
                </button>
                <label class="btn btn-link p-0" for="chatPhotos"
                    style="color: #6b7280; width: 24px; height: 24px; border-radius: 50%; transition: all 0.2s; display: flex; align-items: center; justify-content: center;"
                    title="Gửi hình ảnh">
                    <i class="fa-solid fa-image" style="font-size: 14px; display: block; line-height: 1;"></i>
                </label>
                <input class="d-none" type="file" accept="image/*" id="chatPhotos" />
                <label class="btn btn-link p-0" for="chatAttachment"
                    style="color: #6b7280; width: 24px; height: 24px; border-radius: 50%; transition: all 0.2s; display: flex; align-items: center; justify-content: center;"
                    title="Gửi file">
                    <i class="fa-solid fa-paperclip" style="font-size: 14px; display: block; line-height: 1;"></i>
                </label>
                <input class="d-none" type="file" id="chatAttachment" />
                <button class="btn btn-link p-0" type="button" id="voice-btn"
                    style="color: #6b7280; width: 24px; height: 24px; border-radius: 50%; transition: all 0.2s; display: flex; align-items: center; justify-content: center;"
                    title="Ghi âm">
                    <i class="fa-solid fa-microphone" style="font-size: 14px; display: block; line-height: 1;"></i>
                </button>
                <button class="btn btn-link p-0 send-btn" id="chat-send-btn"
                    style="color: #3b82f6; width: 24px; height: 24px; border-radius: 50%; transition: all 0.2s; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-paper-plane" style="font-size: 14px; display: block; line-height: 1;"></i>
                </button>
            </div>
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

    /* Chat input icons hover effects */
    #client-support-chat .btn-link:hover {
      background-color: rgba(107, 114, 128, 0.1) !important;
      transform: scale(1.1);
      text-decoration: none !important;
    }

    #client-support-chat .btn-link:active {
      background-color: rgba(107, 114, 128, 0.2) !important;
      transform: scale(0.95);
    }

    #client-support-chat .send-btn:hover {
      background-color: rgba(59, 130, 246, 0.1) !important;
      transform: scale(1.1);
      text-decoration: none !important;
    }

    #client-support-chat .send-btn:active {
      background-color: rgba(59, 130, 246, 0.2) !important;
      transform: scale(0.95);
    }

    /* Đảm bảo tất cả icon thẳng hàng hoàn hảo */
    #client-support-chat .btn-link i {
      display: block !important;
      line-height: 1 !important;
      text-align: center !important;
      width: 100% !important;
      height: 100% !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
    }

    #client-support-chat .btn-link {
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      line-height: 1 !important;
      padding: 0 !important;
      margin: 0 !important;
      text-decoration: none !important;
      border: none !important;
      outline: none !important;
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

        // Cuộn xuống tin nhắn mới nhất khi mở chat
        setTimeout(() => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 200);
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
    let isEmojiPickerOpen = false;

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

        // Xử lý nội dung tin nhắn dựa trên type
        let messageContent = '';
        if (msg.type === 'image' && msg.attachment) {
            messageContent = `
                <div style="background: ${isMe ? 'linear-gradient(135deg, #3b82f6, #60a5fa)' : '#232946'}; padding: 8px; border-radius: 12px; display: inline-block;">
                    <img src="/storage/${msg.attachment}" alt="Hình ảnh" style="max-width: 200px; border-radius: 8px; cursor: pointer;" onclick="openImageModal('/storage/${msg.attachment}')" />
                </div>`;
        } else if (msg.type === 'voice' && msg.attachment) {
            messageContent = `
                <div style="background: ${isMe ? 'linear-gradient(135deg, #3b82f6, #60a5fa)' : '#232946'}; padding: 8px 12px; border-radius: 18px; display: inline-block;">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-microphone me-2" style="color: #fff;"></i>
                        <audio controls style="max-width: 180px; height: 30px;">
                            <source src="/storage/${msg.attachment}" type="audio/webm">
                            <source src="/storage/${msg.attachment}" type="audio/wav">
                            <source src="/storage/${msg.attachment}" type="audio/mp3">
                            Trình duyệt không hỗ trợ phát audio.
                        </audio>
                    </div>
                </div>`;
        } else if (msg.type === 'file' && msg.attachment) {
            messageContent = `
                <div style="background: ${isMe ? 'linear-gradient(135deg, #3b82f6, #60a5fa)' : '#232946'}; padding: 8px 12px; border-radius: 18px; display: inline-block;">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-file me-2" style="color: #fff;"></i>
                        <a href="/storage/${msg.attachment}" target="_blank" class="text-decoration-none" style="color: #fff; font-size: 14px;">
                            ${msg.message}
                        </a>
                        <i class="fa-solid fa-download ms-2" style="color: #fff; font-size: 12px;"></i>
                    </div>
                </div>`;
        } else {
            messageContent =
                `<span style="display: inline-block; padding: 8px 14px; border-radius: 18px; font-size: 15px; background: ${isMe ? 'linear-gradient(135deg, #3b82f6, #60a5fa)' : '#232946'}; color: #fff; box-shadow: 0 1px 4px rgba(60,60,60,0.04); word-break: break-word;">${msg.message}</span>`;
        }

        div.innerHTML = `
            <div style="
                max-width: 75%;
                display: flex;
                align-items: flex-end;
                gap: 6px;
            " data-message-id="${msg.id || 'temp-' + Date.now()}">
                ${!isMe ? `<img src='{{ auth()->check() && auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png' }}' style='width:22px;height:22px;border-radius:50%;border:1.5px solid #fff;box-shadow:0 1px 2px #0001;'/>` : ''}
                <div style="display: flex; flex-direction: column; align-items: ${isMe ? 'flex-end' : 'flex-start'};">
                    ${messageContent}
                    <span style="font-size:11px;color:#aaa;margin-top:2px;${isMe ? 'text-align:right;' : 'text-align:left;'}">${time}</span>
                </div>
            </div>
        `;
        chatMessages.appendChild(div);
        // Cuộn xuống tin nhắn mới nhất với animation mượt mà
        setTimeout(() => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 50);
    }

    // Load lịch sử chat khi mở chat
    function loadHistory() {
        fetch('/client/chat/conversation/' + userId)
            .then(res => res.json())
            .then(data => {
                chatMessages.innerHTML = '';
                if (data.messages?.length > 0) {
                    data.messages.forEach(msg => appendMessage(msg, msg.from_id == userId));
                    // Đảm bảo cuộn xuống tin nhắn mới nhất ngay sau khi load
                    setTimeout(() => {
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }, 50);
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

    // Xử lý emoji picker
    const emojiBtn = document.getElementById('emoji-btn');
    const emojiContainer = document.getElementById('emoji-picker-container');

    if (emojiBtn) {
        emojiBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Emoji button clicked!');

            if (!isEmojiPickerOpen) {
                // Tạo emoji picker
                if (emojiContainer.children.length === 0) {
                    const commonEmojis = [
                        '😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇',
                        '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘', '😗', '😙', '😚',
                        '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩',
                        '🥳', '😏', '😒', '😞', '😔', '😟', '😕', '🙁', '☹️', '😣',
                        '😖', '😫', '😩', '🥺', '😢', '😭', '😤', '😠', '😡', '🤬',
                        '🤯', '😳', '🥵', '🥶', '😱', '😨', '😰', '😥', '😓', '🤗',
                        '🤔', '🤭', '🤫', '🤥', '😶', '😐', '😑', '😯', '😦', '😧',
                        '😮', '😲', '🥱', '😴', '🤤', '😪', '😵', '🤐', '🥴', '🤢',
                        '🤮', '🤧', '😷', '🤒', '🤕', '🤑', '🤠', '💩', '🤡', '👹',
                        '👺', '👻', '👽', '👾', '🤖', '😺', '😸', '😹', '😻', '😼',
                        '😽', '🙀', '😿', '😾', '🙈', '🙉', '🙊', '💌', '💘', '💝',
                        '💖', '💗', '💙', '💚', '❣️', '💕', '💞', '💓', '💗', '💖',
                        '💘', '💝', '💟', '❤️', '🧡', '💛', '💚', '💙', '💜', '🖤',
                        '🤍', '🤎', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘',
                        '💝', '💟', '👍', '👎', '👌', '✌️', '🤞', '🤟', '🤘', '🤙',
                        '👈', '👉', '👆', '🖕', '👇', '☝️', '👋', '🤚', '🖐️', '✋',
                        '🖖', '👌', '🤌', '🤏', '✌️', '🤞', '🤟', '🤘', '🤙', '👈',
                        '👉', '👆', '🖕', '👇', '☝️', '👋', '🤚', '🖐️', '✋', '🖖'
                    ];

                    const emojiGrid = document.createElement('div');
                    emojiGrid.className = 'emoji-grid';
                    emojiGrid.style.cssText = `
                        display: grid;
                        grid-template-columns: repeat(8, 1fr);
                        gap: 5px;
                        padding: 10px;
                        max-height: 200px;
                        overflow-y: auto;
                        background: white;
                        border-radius: 8px;
                        border: 1px solid #e9ecef;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    `;

                    commonEmojis.forEach(emoji => {
                        const emojiBtn = document.createElement('button');
                        emojiBtn.textContent = emoji;
                        emojiBtn.style.cssText = `
                            border: none;
                            background: none;
                            font-size: 20px;
                            cursor: pointer;
                            padding: 5px;
                            border-radius: 4px;
                            transition: background-color 0.2s;
                        `;

                        emojiBtn.addEventListener('mouseenter', () => {
                            emojiBtn.style.backgroundColor = '#f0f0f0';
                        });

                        emojiBtn.addEventListener('mouseleave', () => {
                            emojiBtn.style.backgroundColor = 'transparent';
                        });

                        emojiBtn.addEventListener('click', () => {
                            insertEmoji(emoji);
                            emojiContainer.style.display = 'none';
                            isEmojiPickerOpen = false;
                        });

                        emojiGrid.appendChild(emojiBtn);
                    });

                    emojiContainer.appendChild(emojiGrid);
                }

                emojiContainer.style.display = 'block';
                isEmojiPickerOpen = true;
            } else {
                emojiContainer.style.display = 'none';
                isEmojiPickerOpen = false;
            }
        });
    }

    // Hàm chèn emoji vào input
    function insertEmoji(emoji) {
        if (!chatInput) return;

        chatInput.focus();
        const start = chatInput.selectionStart;
        const end = chatInput.selectionEnd;
        const text = chatInput.value;
        const before = text.substring(0, start);
        const after = text.substring(end, text.length);

        chatInput.value = before + emoji + after;
        chatInput.selectionStart = chatInput.selectionEnd = start + emoji.length;
    }

    // Đóng emoji picker khi click ra ngoài
    document.addEventListener('click', function(e) {
        const emojiBtn = document.getElementById('emoji-btn');
        const container = document.getElementById('emoji-picker-container');

        if (!emojiBtn.contains(e.target) && !container.contains(e.target)) {
            container.style.display = 'none';
            isEmojiPickerOpen = false;
        }
    });

    // Xử lý gửi hình ảnh
    document.getElementById('chatPhotos').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('to_id', adminId);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('/client/chat/send-image', {
            method: 'POST',
            body: formData
        }).then(res => res.json()).then(data => {
            appendMessage({
                message: '[IMAGE]',
                attachment: data.message.attachment,
                type: 'image'
            }, true);
        });

        e.target.value = '';
    });

    // Xử lý gửi file
    document.getElementById('chatAttachment').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 10 * 1024 * 1024) {
            alert('File quá lớn. Kích thước tối đa là 10MB.');
            e.target.value = '';
            return;
        }

        const formData = new FormData();
        formData.append('file', file);
        formData.append('to_id', adminId);
        formData.append('_token', '{{ csrf_token() }}');

        const label = document.querySelector('label[for="chatAttachment"]');
        const span = label ? label.querySelector('span') : null;
        const originalText = span ? span.textContent : '📎';
        if (span) {
            span.textContent = '⏳';
        }
        label.disabled = true;

        fetch('/client/chat/send-file', {
                method: 'POST',
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(data => {
                appendMessage({
                    message: data.message.message,
                    attachment: data.message.attachment,
                    type: 'file'
                }, true);
            })
            .catch(error => {
                console.error('Error sending file:', error);
                alert('Lỗi khi gửi file: ' + error.message);
            })
            .finally(() => {
                const label = document.querySelector('label[for="chatAttachment"]');
                const span = label ? label.querySelector('span') : null;
                if (span) {
                    span.textContent = originalText;
                }
                label.disabled = false;
                e.target.value = '';
            });
    });

    // Xử lý ghi âm voice
    let mediaRecorder;
    let audioChunks = [];
    let isRecording = false;

    document.getElementById('voice-btn').addEventListener('click', function() {
        if (!isRecording) {
            // Bắt đầu ghi âm
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert('Trình duyệt không hỗ trợ ghi âm');
                return;
            }

            navigator.mediaDevices.getUserMedia({
                    audio: {
                        echoCancellation: true,
                        noiseSuppression: true,
                        sampleRate: 44100
                    }
                })
                .then(stream => {
                    let mimeType = 'audio/webm;codecs=opus';
                    if (!MediaRecorder.isTypeSupported(mimeType)) {
                        mimeType = 'audio/webm';
                    }
                    if (!MediaRecorder.isTypeSupported(mimeType)) {
                        mimeType = 'audio/mp4';
                    }
                    if (!MediaRecorder.isTypeSupported(mimeType)) {
                        mimeType = '';
                    }

                    mediaRecorder = new MediaRecorder(stream, mimeType ? {
                        mimeType
                    } : {});
                    audioChunks = [];

                    mediaRecorder.ondataavailable = (event) => {
                        if (event.data.size > 0) {
                            audioChunks.push(event.data);
                        }
                    };

                    mediaRecorder.onstop = () => {
                        if (audioChunks.length === 0) {
                            alert('Không có dữ liệu âm thanh');
                            return;
                        }

                        const audioBlob = new Blob(audioChunks, {
                            type: mimeType || 'audio/webm'
                        });

                        const formData = new FormData();
                        formData.append('voice', audioBlob, 'voice.webm');
                        formData.append('to_id', adminId);
                        formData.append('_token', '{{ csrf_token() }}');

                        this.innerHTML = '<span class="fa-solid fa-spinner fa-spin"></span>';
                        this.disabled = true;

                        fetch('/client/chat/send-voice', {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => {
                                if (!res.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return res.json();
                            })
                            .then(data => {
                                appendMessage({
                                    message: '[VOICE]',
                                    attachment: data.message.attachment,
                                    type: 'voice'
                                }, true);
                            })
                            .catch(error => {
                                console.error('Error sending voice:', error);
                                alert('Lỗi khi gửi voice message: ' + error.message);
                            })
                            .finally(() => {
                                this.innerHTML =
                                    '<span class="fa-solid fa-microphone fs-5"></span>';
                                this.disabled = false;
                            });
                    };

                    mediaRecorder.onerror = (event) => {
                        console.error('MediaRecorder error:', event);
                        alert('Lỗi khi ghi âm');
                        isRecording = false;
                        this.innerHTML = '<span class="fa-solid fa-microphone fs-5"></span>';
                        this.title = 'Ghi âm';
                    };

                    mediaRecorder.start(1000);
                    isRecording = true;
                    this.innerHTML = '<span class="fa-solid fa-stop text-danger"></span>';
                    this.title = 'Dừng ghi âm';
                })
                .catch(err => {
                    console.error('Không thể truy cập microphone:', err);
                    alert('Không thể truy cập microphone. Vui lòng kiểm tra quyền truy cập và thử lại.');
                });
        } else {
            // Dừng ghi âm
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                mediaRecorder.stream.getTracks().forEach(track => track.stop());
            }
            isRecording = false;
            this.innerHTML = '<span class="fa-solid fa-microphone fs-5"></span>';
            this.title = 'Ghi âm';
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

    // Lắng nghe event xóa tin nhắn
    channel.bind('message-deleted', data => {
        // Tìm và xóa tin nhắn khỏi DOM
        const messageElement = document.querySelector(`[data-message-id="${data.message_id}"]`);
        if (messageElement) {
            messageElement.remove();
        }
    });

    // Hàm mở modal xem hình ảnh tự custom
    window.openImageModal = function(imageSrc) {
        // Tạo modal overlay
        const modalOverlay = document.createElement('div');
        modalOverlay.id = 'imageModalOverlay';
        modalOverlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;

        // Tạo modal content
        const modalContent = document.createElement('div');
        modalContent.style.cssText = `
            background: white;
            border-radius: 12px;
            padding: 20px;
            max-width: 90%;
            max-height: 90%;
            position: relative;
            transform: scale(0.8);
            transition: transform 0.3s ease;
        `;

        // Header với nút đóng
        const header = document.createElement('div');
        header.style.cssText = `
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        `;
        header.innerHTML = `
            <h5 style="margin: 0; color: #333; font-size: 18px;">Xem hình ảnh</h5>
            <button id="closeModalBtn" style="
                background: none;
                border: none;
                font-size: 24px;
                cursor: pointer;
                color: #666;
                padding: 0;
                width: 30px;
                height: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                transition: background-color 0.2s;
            ">&times;</button>
        `;

        // Hình ảnh
        const image = document.createElement('img');
        image.src = imageSrc;
        image.style.cssText = `
            max-width: 100%;
            max-height: 70vh;
            border-radius: 8px;
            display: block;
        `;

        // Ghép các phần lại
        modalContent.appendChild(header);
        modalContent.appendChild(image);
        modalOverlay.appendChild(modalContent);
        document.body.appendChild(modalOverlay);

        // Hiển thị modal với animation
        setTimeout(() => {
            modalOverlay.style.opacity = '1';
            modalContent.style.transform = 'scale(1)';
        }, 10);

        // Xử lý đóng modal
        function closeModal() {
            modalOverlay.style.opacity = '0';
            modalContent.style.transform = 'scale(0.8)';
            setTimeout(() => {
                if (modalOverlay.parentNode) {
                    document.body.removeChild(modalOverlay);
                }
            }, 300);
        }

        // Event listeners
        document.getElementById('closeModalBtn').addEventListener('click', closeModal);
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) {
                closeModal();
            }
        });

        // Đóng bằng phím ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    };
</script>
