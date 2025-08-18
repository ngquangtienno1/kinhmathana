@extends('admin.layouts')

@section('title', 'Chat với khách hàng')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.chat.index') }}">Chat với khách hàng</a>
    </li>
@endsection

@section('content')
    <!-- Chat Container -->
    <div class="chat d-flex phoenix-offcanvas-container" style="height: calc(100vh - 200px);">
        <!-- Sidebar: Danh sách khách hàng -->
        <div class="card p-3 p-xl-1 chat-sidebar me-3 phoenix-offcanvas phoenix-offcanvas-start" id="chat-sidebar"
            style="width: 300px; min-width: 320px;">
            <div class="form-icon-container mb-4 d-sm-none d-xl-block">
                <input class="form-control form-icon-input" type="text" id="search-user"
                    placeholder="Tìm kiếm khách hàng..." />
                <span class="fas fa-user text-body fs-9 form-icon"></span>
            </div>
            <ul class="nav nav-phoenix-pills mb-5 d-sm-none d-xl-flex" id="contactListTab"
                data-chat-thread-tab="data-chat-thread-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link cursor-pointer active" data-bs-toggle="tab" data-chat-thread-list="all"
                        role="tab" aria-selected="true">Tất cả</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link cursor-pointer" data-bs-toggle="tab" role="tab" data-chat-thread-list="read"
                        aria-selected="false">Đã đọc</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link cursor-pointer" data-bs-toggle="tab" role="tab" data-chat-thread-list="unread"
                        aria-selected="false">Chưa đọc</a>
                </li>
            </ul>
            <div class="scrollbar" style="height: calc(100vh - 350px); overflow-y: auto;">
                <div class="tab-content" id="contactListTabContent">
                    <div data-chat-thread-tab-content="data-chat-thread-tab-content">
                        <ul class="nav chat-thread-tab flex-column list" id="user-list">
                            @foreach ($users as $user)
                                <li class="nav-item read" role="presentation">
                                    <a class="nav-link d-flex align-items-center justify-content-center p-2 user-item"
                                        data-user-id="{{ $user->id }}" data-bs-toggle="tab"
                                        data-chat-thread="data-chat-thread" href="#tab-thread-{{ $user->id }}"
                                        role="tab" aria-selected="false">
                                        <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2">
                                            <img class="rounded-circle border border-2 border-light-subtle"
                                                src="{{ $user->avatar ? asset($user->avatar) : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png' }}"
                                                alt="" />
                                        </div>
                                        <div class="flex-1 d-sm-none d-xl-block">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="text-body fw-normal name text-nowrap">{{ $user->name }}
                                                </h5>
                                                <p class="fs-10 text-body-tertiary text-opacity-85 mb-0 text-nowrap"
                                                    id="last-time-{{ $user->id }}"></p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="fs-9 mb-0 line-clamp-1 text-body-tertiary text-opacity-85 message"
                                                    id="last-msg-{{ $user->id }}"></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Khung chat chính -->
        <div class="card tab-content flex-1 phoenix-offcanvas-container">
            <div class="tab-pane h-100 fade active show" id="tab-thread-default" role="tabpanel"
                aria-labelledby="tab-thread-default">
                <div class="d-flex flex-column h-100">
                    <!-- Header chat -->
                    <div class="card-header p-3 p-md-4 d-flex flex-between-center" id="chat-header">
                        <div class="d-flex align-items-center">
                            <button class="btn ps-0 pe-2 text-body-tertiary d-sm-none" data-phoenix-toggle="offcanvas"
                                data-phoenix-target="#chat-sidebar">
                                <span class="fa-solid fa-chevron-left"></span>
                            </button>
                            <div class="d-flex flex-column flex-md-row align-items-md-center">
                                <button
                                    class="btn fs-7 fw-semibold text-body-emphasis d-flex align-items-center p-0 me-3 text-start"
                                    data-phoenix-toggle="offcanvas" data-phoenix-target="#thread-details-0">
                                    <span class="line-clamp-1" id="chat-with">Chọn khách hàng để chat</span>
                                    <span class="fa-solid fa-chevron-down ms-2 fs-10"></span>
                                </button>
                                <p class="fs-9 mb-0 me-2" id="user-status" style="display: none;">
                                    <span class="fa-solid fa-circle text-success fs-11 me-2"></span>Đang hoạt động
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-icon btn-primary me-1" id="toggle-sidebar-btn"
                                title="Thu gọn danh sách khách hàng">
                                <span class="fa-solid fa-bars"></span>
                            </button>
                            <button class="btn btn-icon btn-phoenix-primary" type="button" data-bs-toggle="dropdown"
                                data-boundary="window" aria-haspopup="true" aria-expanded="false"
                                data-bs-reference="parent">
                                <span class="fa-solid fa-ellipsis-vertical"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-0">
                                <li><a class="dropdown-item" href="#!">Thêm vào yêu thích</a></li>
                                <li><a class="dropdown-item" href="#!">Xem hồ sơ</a></li>
                                <li><a class="dropdown-item" href="#!">Báo cáo</a></li>
                                <li><a class="dropdown-item" href="#!">Quản lý thông báo</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Nội dung chat -->
                    <div class="card-body p-3 p-sm-4 scrollbar chat-content-body-0" id="chat-messages"
                        style="flex: 1; overflow-y: auto;">
                        <div class="text-center text-muted mt-3">Chọn khách hàng để bắt đầu chat</div>
                    </div>

                    <!-- Footer chat -->
                    <div class="card-footer">
                        <form id="chat-form" class="d-flex flex-column">
                            <div class="chat-textarea outline-none scrollbar mb-1" contenteditable="true" id="chat-input"
                                placeholder="Nhập tin nhắn..."
                                style="min-height: 40px; max-height: 120px; overflow-y: auto;"></div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="position-relative">
                                    <button class="btn btn-link py-0 ps-0 pe-2 text-body fs-9" type="button"
                                        id="emoji-btn" title="Chọn emoji">
                                        <span class="fa-regular fa-face-smile"></span>
                                    </button>
                                    <div id="emoji-picker-container"
                                        style="position: absolute; bottom: 100%; left: 0; z-index: 1000; display: none;">
                                    </div>
                                    <label class="btn btn-link py-0 px-2 text-body fs-9" for="chatPhotos-0"
                                        title="Gửi hình ảnh">
                                        <span class="fa-solid fa-image"></span>
                                    </label>
                                    <input class="d-none" type="file" accept="image/*" id="chatPhotos-0" />
                                    <label class="btn btn-link py-0 px-2 text-body fs-9" for="chatAttachment-0"
                                        title="Gửi file">
                                        <span class="fa-solid fa-paperclip"></span>
                                    </label>
                                    <input class="d-none" type="file" id="chatAttachment-0" />
                                    <button class="btn btn-link py-0 px-2 text-body fs-9" type="button" id="voice-btn"
                                        title="Ghi âm">
                                        <span class="fa-solid fa-microphone"></span>
                                    </button>
                                    <button class="btn btn-link py-0 px-2 text-body fs-9" type="button">
                                        <span class="fa-solid fa-ellipsis"></span>
                                    </button>
                                </div>
                                <div>
                                    <button class="btn btn-primary fs-10" type="submit" id="send-btn" disabled>
                                        <span class="fa-solid fa-paper-plane"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <meta name="admin-id" content="{{ auth()->id() }}">
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userIds = @json($users->pluck('id'));
            let selectedUserId = null;
            let adminId = document.querySelector('meta[name="admin-id"]').getAttribute('content');
            let chatInput = document.getElementById('chat-input');
            let chatForm = document.getElementById('chat-form');
            let chatMessages = document.getElementById('chat-messages');
            let chatWith = document.getElementById('chat-with');
            let sendBtn = document.getElementById('send-btn');
            let userStatus = document.getElementById('user-status');
            let isEmojiPickerOpen = false;

            // Xử lý click vào user item
            document.querySelectorAll('.user-item').forEach(item => {
                item.addEventListener('click', function() {
                    selectedUserId = this.getAttribute('data-user-id');
                    const name = this.querySelector('.name').textContent;
                    const avatar = this.querySelector('img').getAttribute('src');

                    // Cập nhật header
                    chatWith.textContent = name;
                    userStatus.style.display = '';

                    // Kích hoạt input và button
                    chatInput.contentEditable = true;
                    sendBtn.disabled = false;

                    // Load conversation
                    loadConversation(selectedUserId);

                    // Cập nhật active state
                    document.querySelectorAll('.user-item').forEach(i => i.classList.remove(
                        'active'));
                    this.classList.add('active');
                });
            });

            function appendMessage(msg, isAdmin) {
                let div = document.createElement('div');
                let adminAvatar =
                    '{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png' }}';
                let user = null;
                if (!isAdmin && window.usersData) {
                    user = window.usersData.find(u => u.id == msg.from_id);
                }
                let userAvatar = user && user.avatar ? user.avatar :
                    'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png';
                let time = msg.created_at ? formatTime(msg.created_at) : '';

                // Xử lý nội dung tin nhắn dựa trên type
                let messageContent = '';
                if (msg.type === 'image' && msg.attachment) {
                    messageContent =
                        `<img src="/storage/${msg.attachment}" alt="Hình ảnh" style="max-width: 200px; border-radius: 8px; cursor: pointer;" onclick="openImageModal('/storage/${msg.attachment}')" />`;
                } else if (msg.type === 'voice' && msg.attachment) {
                    messageContent = `
                        <div class="d-flex align-items-center">
                            <audio controls style="max-width: 200px;">
                                <source src="/storage/${msg.attachment}" type="audio/webm">
                                <source src="/storage/${msg.attachment}" type="audio/wav">
                                <source src="/storage/${msg.attachment}" type="audio/mp3">
                                Trình duyệt không hỗ trợ phát audio.
                            </audio>
                        </div>`;
                } else if (msg.type === 'file' && msg.attachment) {
                    // Màu sắc phù hợp với loại tin nhắn
                    const textColor = isAdmin ? 'text-white' : 'text-dark';
                    messageContent = `
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-file me-2"></i>
                            <a href="/storage/${msg.attachment}" target="_blank" class="text-decoration-none ${textColor}">
                                ${msg.message}
                            </a>
                        </div>`;
                } else {
                    messageContent = `<p class="mb-0">${msg.message}</p>`;
                }

                if (isAdmin) {
                    // Tin nhắn từ admin (bên phải)
                    div.innerHTML = `
                        <div class="d-flex chat-message" data-message-id="${msg.id || 'temp-' + Date.now()}">
                            <div class="d-flex mb-2 justify-content-end flex-1">
                                <div class="w-100 w-xxl-75">
                                    <div class="d-flex flex-end-center hover-actions-trigger">
                                        <div class="d-none d-sm-flex">
                                            <div class="hover-actions position-relative align-self-center">
                                                <button class="btn p-2 fs-10 reply-btn" onclick="replyToMessage('${msg.message}', ${isAdmin}, '${msg.type || 'text'}', '${msg.attachment || ''}')" title="Trả lời">
                                                    <span class="fa-solid fa-reply text-primary"></span>
                                                </button>
                                                <button class="btn p-2 fs-10 edit-btn" onclick="editMessage(this, '${msg.message}', ${msg.id || 'temp-' + Date.now()})" title="Chỉnh sửa">
                                                    <span class="fa-solid fa-pen-to-square text-primary"></span>
                                                </button>
                                                <button class="btn p-2 fs-10 delete-btn" onclick="deleteMessage(${msg.id || 'temp-' + Date.now()})" title="Xóa">
                                                    <span class="fa-solid fa-trash text-primary"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="chat-message-content me-2">
                                            <div class="mb-1 sent-message-content bg-primary rounded-2 p-3 text-white" data-bs-theme="light">
                                                ${messageContent}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 fs-10 text-body-tertiary text-opacity-85 fw-semibold">${time}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    // Tin nhắn từ user (bên trái)
                    div.innerHTML = `
                        <div class="d-flex chat-message" data-message-id="${msg.id || 'temp-' + Date.now()}">
                            <div class="d-flex mb-2 flex-1">
                                <div class="w-100 w-xxl-75">
                                    <div class="d-flex hover-actions-trigger">
                                        <div class="avatar avatar-m me-3 flex-shrink-0">
                                            <img class="rounded-circle" src="${userAvatar}" alt="" />
                                        </div>
                                        <div class="chat-message-content received me-2">
                                            <div class="mb-1 received-message-content border rounded-2 p-3">
                                                ${messageContent}
                                            </div>
                                        </div>
                                        <div class="d-none d-sm-flex">
                                            <div class="hover-actions position-relative align-self-center me-2">
                                                <button class="btn p-2 fs-10 reply-btn" onclick="replyToMessage('${msg.message}', ${isAdmin}, '${msg.type || 'text'}', '${msg.attachment || ''}')" title="Trả lời">
                                                    <span class="fa-solid fa-reply"></span>
                                                </button>
                                                <button class="btn p-2 fs-10 delete-btn" onclick="deleteMessage(${msg.id || 'temp-' + Date.now()})" title="Xóa">
                                                    <span class="fa-solid fa-trash"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-0 fs-10 text-body-tertiary text-opacity-85 fw-semibold ms-7">${time}</p>
                                </div>
                    </div>
                </div>
            `;
                }
                chatMessages.appendChild(div);
            }

            // Format thời gian
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

            // Cập nhật last message + time ở sidebar
            function updateSidebarLastMsg(userId, msg, time) {
                const lastMsg = document.getElementById('last-msg-' + userId);
                const lastTime = document.getElementById('last-time-' + userId);
                if (lastMsg) lastMsg.textContent = msg;
                if (lastTime) lastTime.textContent = formatTime(time);
            }

            // Khi load conversation, cập nhật last message/time
            function loadConversation(userId) {
                chatMessages.innerHTML = '<div class="text-center text-muted mt-3">Đang tải...</div>';
                fetch('/admin/chat/conversation/' + userId)
                    .then(res => res.json())
                    .then(data => {
                        chatMessages.innerHTML = '';
                        if (data.messages.length > 0) {
                            data.messages.forEach(msg => {
                                appendMessage(msg, msg.from_id == adminId);
                            });
                            // Cập nhật last message/time ở sidebar
                            const last = data.messages[data.messages.length - 1];
                            updateSidebarLastMsg(userId, last.message, last.created_at);
                        }
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    });
            }

            // Pusher realtime
            var pusher = new Pusher('470ba5e93dce15022f9e', {
                cluster: 'ap1',
                forceTLS: true
            });
            var adminChannel = pusher.subscribe('chat-user-' + adminId);
            adminChannel.bind('chat-message', function(data) {
                if (selectedUserId == data.from_id) {
                    appendMessage(data, false);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
                updateSidebarLastMsg(data.from_id, data.message, new Date());
            });

            // Lắng nghe event xóa tin nhắn cho admin channel
            adminChannel.bind('message-deleted', function(data) {
                const messageElement = document.querySelector(`[data-message-id="${data.message_id}"]`);
                if (messageElement) {
                    messageElement.remove();
                }
            });

            @foreach ($users as $user)
                var channelName = 'chat-user-{{ $user->id }}';
                var channel = pusher.subscribe(channelName);
                channel.bind('chat-message', function(data) {
                    if (selectedUserId == data.from_id) {
                        appendMessage(data, false);
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
                });

                // Lắng nghe event xóa tin nhắn cho mỗi user
                channel.bind('message-deleted', function(data) {
                    const messageElement = document.querySelector(`[data-message-id="${data.message_id}"]`);
                    if (messageElement) {
                        messageElement.remove();
                    }
                });
            @endforeach

            // Xử lý gửi tin nhắn
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!selectedUserId) return;

                let message = chatInput.textContent.trim();
                if (!message) return;

                fetch('/admin/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        to_id: selectedUserId,
                        message: message
                    })
                }).then(res => res.json()).then(data => {
                    appendMessage({
                        message: message
                    }, true);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                });

                chatInput.textContent = '';
            });

            // Xử lý gửi hình ảnh
            document.getElementById('chatPhotos-0').addEventListener('change', function(e) {
                if (!selectedUserId) return;

                const file = e.target.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('image', file);
                formData.append('to_id', selectedUserId);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('/admin/chat/send-image', {
                    method: 'POST',
                    body: formData
                }).then(res => res.json()).then(data => {
                    appendMessage({
                        message: '[IMAGE]',
                        attachment: data.message.attachment,
                        type: 'image'
                    }, true);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                });

                e.target.value = '';
            });

            // Xử lý gửi file
            document.getElementById('chatAttachment-0').addEventListener('change', function(e) {
                if (!selectedUserId) {
                    alert('Vui lòng chọn khách hàng để chat');
                    e.target.value = '';
                    return;
                }

                const file = e.target.files[0];
                if (!file) return;

                if (file.size > 10 * 1024 * 1024) {
                    alert('File quá lớn. Kích thước tối đa là 10MB.');
                    e.target.value = '';
                    return;
                }

                const formData = new FormData();
                formData.append('file', file);
                formData.append('to_id', selectedUserId);
                formData.append('_token', '{{ csrf_token() }}');

                const label = document.querySelector('label[for="chatAttachment-0"]');
                const span = label ? label.querySelector('span') : null;
                const originalText = span ? span.textContent : '📎';
                if (span) {
                    span.textContent = '⏳';
                }
                label.disabled = true;

                fetch('/admin/chat/send-file', {
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
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    })
                    .catch(error => {
                        console.error('Error sending file:', error);
                        alert('Lỗi khi gửi file: ' + error.message);
                    })
                    .finally(() => {
                        const label = document.querySelector('label[for="chatAttachment-0"]');
                        const span = label ? label.querySelector('span') : null;
                        if (span) {
                            span.textContent = originalText;
                        }
                        label.disabled = false;
                        e.target.value = '';
                    });
            });

            // Xử lý ghi âm
            let mediaRecorder;
            let audioChunks = [];
            let isRecording = false;

            document.getElementById('voice-btn').addEventListener('click', function() {
                if (!selectedUserId) {
                    alert('Vui lòng chọn khách hàng để chat');
                    return;
                }

                if (!isRecording) {
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
                                formData.append('to_id', selectedUserId);
                                formData.append('_token', '{{ csrf_token() }}');

                                this.innerHTML =
                                    '<span class="fa-solid fa-spinner fa-spin"></span>';
                                this.disabled = true;

                                fetch('/admin/chat/send-voice', {
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
                                        chatMessages.scrollTop = chatMessages.scrollHeight;
                                    })
                                    .catch(error => {
                                        console.error('Error sending voice:', error);
                                        alert('Lỗi khi gửi voice message: ' + error.message);
                                    })
                                    .finally(() => {
                                        this.innerHTML =
                                            '<span class="fa-solid fa-microphone"></span>';
                                        this.disabled = false;
                                    });
                            };

                            mediaRecorder.onerror = (event) => {
                                console.error('MediaRecorder error:', event);
                                alert('Lỗi khi ghi âm');
                                isRecording = false;
                                this.innerHTML = '<span class="fa-solid fa-microphone"></span>';
                                this.title = 'Ghi âm';
                            };

                            mediaRecorder.start(1000);
                            isRecording = true;
                            this.innerHTML = '<span class="fa-solid fa-stop text-danger"></span>';
                            this.title = 'Dừng ghi âm';
                        })
                        .catch(err => {
                            console.error('Không thể truy cập microphone:', err);
                            alert(
                                'Không thể truy cập microphone. Vui lòng kiểm tra quyền truy cập và thử lại.'
                            );
                        });
                } else {
                    if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                        mediaRecorder.stop();
                        mediaRecorder.stream.getTracks().forEach(track => track.stop());
                    }
                    isRecording = false;
                    this.innerHTML = '<span class="fa-solid fa-microphone"></span>';
                    this.title = 'Ghi âm';
                }
            });

            // Xử lý Enter để gửi tin nhắn
            chatInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    chatForm.dispatchEvent(new Event('submit'));
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

                const selection = window.getSelection();
                const range = selection.getRangeAt(0);

                const textNode = document.createTextNode(emoji);
                range.deleteContents();
                range.insertNode(textNode);
                range.collapse(false);

                selection.removeAllRanges();
                selection.addRange(range);
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

            // Tìm kiếm
            let searchTimeout = null;
            document.getElementById('search-user').addEventListener('input', function() {
                let val = this.value.toLowerCase();
                if (searchTimeout) clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    fetch(`?q=${encodeURIComponent(val)}`)
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newList = doc.getElementById('user-list');
                            if (newList) {
                                document.getElementById('user-list').innerHTML = newList
                                    .innerHTML;
                                // Re-attach event listeners
                                document.querySelectorAll('.user-item').forEach(item => {
                                    item.addEventListener('click', function() {
                                        document.querySelectorAll('.user-item')
                                            .forEach(i => i.classList.remove(
                                                'active'));
                                        this.classList.add('active');
                                        selectedUserId = this.getAttribute(
                                            'data-user-id');
                                        const name = this.querySelector('.name')
                                            .textContent;
                                        chatWith.textContent = name;
                                        userStatus.style.display = '';
                                        chatInput.contentEditable = true;
                                        sendBtn.disabled = false;
                                        loadConversation(selectedUserId);
                                    });
                                });
                            }
                        });
                }, 300);
            });

            // Toggle sidebar - Làm lại từ đầu
            const sidebar = document.querySelector('.chat-sidebar');
            const chatCol = document.querySelector('.card.tab-content');
            const toggleSidebarBtn = document.getElementById('toggle-sidebar-btn');

            // Trạng thái ban đầu: sidebar hiển thị
            let isSidebarCollapsed = false;

            // Cập nhật icon ban đầu
            toggleSidebarBtn.innerHTML = '<span class="fa-solid fa-bars"></span>';
            toggleSidebarBtn.title = 'Thu gọn danh sách khách hàng';

            toggleSidebarBtn.onclick = function() {
                isSidebarCollapsed = !isSidebarCollapsed;

                if (isSidebarCollapsed) {
                    // Thu gọn sidebar
                    sidebar.classList.add('collapsed');
                    chatCol.classList.add('expanded');
                    toggleSidebarBtn.innerHTML = '<span class="fa-solid fa-bars-staggered"></span>';
                    toggleSidebarBtn.title = 'Mở rộng danh sách khách hàng';
                } else {
                    // Mở rộng sidebar
                    sidebar.classList.remove('collapsed');
                    chatCol.classList.remove('expanded');
                    toggleSidebarBtn.innerHTML = '<span class="fa-solid fa-bars"></span>';
                    toggleSidebarBtn.title = 'Thu gọn danh sách khách hàng';
                }
            };

            // CSS cho active state và styling
            const style = document.createElement('style');
            style.innerHTML = `
                .user-item.active {
                    background: #e0e7ff !important;
                    border-left: 4px solid #3b82f6;
                }
                .chat-textarea:empty:before {
                    content: attr(placeholder);
                    color: #6c757d;
                    pointer-events: none;
                }
                .chat-sidebar {
                    border-radius: 0.5rem;
                    border: 1px solid #e9ecef;
                    box-shadow: none;
                }
                .card.tab-content {
                    border-radius: 0.5rem;
                    border: 1px solid #e9ecef;
                    box-shadow: none;
                }
                .chat-sidebar .card,
                .card.tab-content .card {
                    border: none;
                    box-shadow: none;
                }
                .chat-sidebar .card-header,
                .card.tab-content .card-header {
                    border-bottom: 1px solid #e9ecef;
                    background: transparent;
                }
                .chat-sidebar .card-footer,
                .card.tab-content .card-footer {
                    border-top: 1px solid #e9ecef;
                    background: transparent;
                }

                /* Emoji picker styling */
                #emoji-picker-container {
                    background: white;
                    border: 1px solid #e9ecef;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    margin-bottom: 10px;
                    position: absolute;
                    bottom: 100%;
                    left: 0;
                    z-index: 1000;
                }

                .emoji-grid {
                    display: grid;
                    grid-template-columns: repeat(8, 1fr);
                    gap: 5px;
                    padding: 10px;
                    max-height: 200px;
                    overflow-y: auto;
                    background: white;
                    border-radius: 8px;
                }

                .emoji-grid button {
                    border: none;
                    background: none;
                    font-size: 20px;
                    cursor: pointer;
                    padding: 5px;
                    border-radius: 4px;
                    transition: background-color 0.2s;
                }

                .emoji-grid button:hover {
                    background-color: #f0f0f0;
                }

                /* Hover actions styling */
                .hover-actions-trigger {
                    position: relative;
                }

                .hover-actions {
                    opacity: 0;
                    transition: opacity 0.2s ease;
                }

                .hover-actions-trigger:hover .hover-actions {
                    opacity: 1;
                }

                .hover-actions .btn {
                    padding: 4px 8px;
                    font-size: 12px;
                    border-radius: 4px;
                    transition: all 0.2s ease;
                }

                .hover-actions .btn:hover {
                    background-color: rgba(59, 130, 246, 0.1);
                    transform: scale(1.1);
                }

                /* Reply preview styling */
                .reply-preview {
                    border-left: 3px solid #3b82f6;
                    background-color: #f8f9fa;
                    font-size: 12px;
                    color: #666;
                    margin-bottom: 8px;
                    padding: 8px;
                    border-radius: 4px;
                }

                /* Sidebar toggle styling */
                .chat-sidebar {
                    transition: all 0.3s ease;
                }

                .card.tab-content {
                    transition: all 0.3s ease;
                }

                .chat-sidebar.collapsed {
                    display: none !important;
                }

                .card.tab-content.expanded {
                    width: 100% !important;
                    margin-left: 0 !important;
                }
            `;
            document.head.appendChild(style);

            window.usersData = @json(
                $users->map(function ($u) {
                    return [
                        'id' => $u->id,
                        'avatar' => $u->avatar
                            ? asset($u->avatar)
                            : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png',
                    ];
                }));

            // Hàm mở modal xem hình ảnh
            window.openImageModal = function(imageSrc) {
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.id = 'imageModal';
                modal.innerHTML = `
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Xem hình ảnh</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="${imageSrc}" class="img-fluid" alt="Hình ảnh" />
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);

                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();

                modal.addEventListener('hidden.bs.modal', function() {
                    document.body.removeChild(modal);
                });
            };

            // Hàm trả lời tin nhắn
            window.replyToMessage = function(message, isAdmin, messageType, attachment) {
                if (!selectedUserId) {
                    alert('Vui lòng chọn khách hàng để chat');
                    return;
                }

                let replyContent = '';

                // Xử lý nội dung dựa trên loại tin nhắn
                if (messageType === 'image' && attachment) {
                    replyContent =
                        `<img src="/storage/${attachment}" alt="Hình ảnh" style="max-width: 100px; max-height: 60px; border-radius: 4px; object-fit: cover;" />`;
                } else if (messageType === 'voice' && attachment) {
                    replyContent = `<i class="fa-solid fa-microphone me-1"></i><span>Tin nhắn thoại</span>`;
                } else if (messageType === 'file' && attachment) {
                    replyContent = `<i class="fa-solid fa-file me-1"></i><span>${message}</span>`;
                } else {
                    replyContent = `<span>${message}</span>`;
                }

                // Hiển thị tin nhắn trả lời ở input
                const replyText = isAdmin ? `Trả lời: ` : `Trả lời khách hàng: `;
                chatInput.innerHTML = `<div class="reply-preview mb-2 p-2 bg-light rounded" style="border-left: 3px solid #3b82f6; font-size: 12px; color: #666;">
                    <i class="fa-solid fa-reply me-1"></i>${replyText}${replyContent}
                    <button type="button" class="btn btn-sm btn-link p-0 ms-2" onclick="removeReply()">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div><br>`;
                chatInput.focus();
            };

            // Hàm xóa preview trả lời
            window.removeReply = function() {
                const replyPreview = chatInput.querySelector('.reply-preview');
                if (replyPreview) {
                    replyPreview.remove();
                }
            };

            // Hàm chỉnh sửa tin nhắn
            window.editMessage = function(button, originalMessage, messageId) {
                const messageDiv = button.closest('.chat-message');
                const messageContent = messageDiv.querySelector(
                    '.sent-message-content, .received-message-content');

                // Tạo input để chỉnh sửa
                const editInput = document.createElement('div');
                editInput.contentEditable = true;
                editInput.className = 'form-control';
                editInput.style.cssText = 'min-height: 40px; max-height: 120px; overflow-y: auto;';
                editInput.textContent = originalMessage;

                // Thay thế nội dung tin nhắn
                const originalContent = messageContent.innerHTML;
                messageContent.innerHTML = '';
                messageContent.appendChild(editInput);
                editInput.focus();

                // Thêm nút lưu và hủy
                const actionButtons = document.createElement('div');
                actionButtons.className = 'mt-2';
                actionButtons.innerHTML = `
                    <button class="btn btn-sm btn-primary me-1" onclick="saveEdit(this, '${originalMessage}', ${messageId})">
                        <i class="fa-solid fa-check"></i> Lưu
                    </button>
                    <button class="btn btn-sm btn-secondary" onclick="cancelEdit(this, '${originalContent}')">
                        <i class="fa-solid fa-times"></i> Hủy
                    </button>
                `;
                messageContent.appendChild(actionButtons);
            };

            // Hàm lưu chỉnh sửa
            window.saveEdit = function(button, originalMessage, messageId) {
                const messageDiv = button.closest('.chat-message');
                const messageContent = messageDiv.querySelector(
                    '.sent-message-content, .received-message-content');
                const editInput = messageContent.querySelector('[contenteditable]');
                const newMessage = editInput.textContent.trim();

                if (newMessage === originalMessage) {
                    // Không thay đổi gì, chỉ hủy edit
                    cancelEdit(button, messageContent.innerHTML);
                    return;
                }

                if (!newMessage) {
                    alert('Tin nhắn không được để trống');
                    return;
                }

                // Gửi request cập nhật tin nhắn
                fetch('/admin/chat/edit-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message_id: messageId,
                            new_message: newMessage
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            messageContent.innerHTML = `<p class="mb-0">${newMessage}</p>`;
                        } else {
                            alert('Lỗi khi cập nhật tin nhắn: ' + data.message);
                            cancelEdit(button, messageContent.innerHTML);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating message:', error);
                        alert('Lỗi khi cập nhật tin nhắn');
                        cancelEdit(button, messageContent.innerHTML);
                    });
            };

            // Hàm hủy chỉnh sửa
            window.cancelEdit = function(button, originalContent) {
                const messageDiv = button.closest('.chat-message');
                const messageContent = messageDiv.querySelector(
                    '.sent-message-content, .received-message-content');
                messageContent.innerHTML = originalContent;
            };



            // Hàm xóa tin nhắn
            window.deleteMessage = function(messageId) {
                if (!confirm('Bạn có chắc chắn muốn xóa tin nhắn này?')) {
                    return;
                }

                fetch('/admin/chat/delete-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message_id: messageId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Xóa tin nhắn khỏi DOM
                            const messageDiv = document.querySelector(`[data-message-id="${messageId}"]`);
                            if (messageDiv) {
                                messageDiv.remove();
                            }
                            alert('Đã xóa tin nhắn thành công!');
                        } else {
                            alert('Lỗi khi xóa tin nhắn: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting message:', error);
                        alert('Lỗi khi xóa tin nhắn');
                    });
            };
        });
    </script>
@endsection
