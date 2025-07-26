@extends('admin.layouts')

@section('title', 'Chat với khách hàng')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.chat.index') }}">Chat</a>
    </li>
    <li class="breadcrumb-item active">Hộp thư khách hàng</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Hộp thư khách hàng</h2>
            </div>
        </div>
        <div class="row" style="height: 70vh;">
            <!-- Sidebar: Danh sách khách hàng -->
            <div class="col-md-3 border-end" style="overflow-y: auto;">
                <div class="search-box mb-3" style="width:100%;">
                    <div style="position:relative;">
                        <input type="text" class="form-control search-input" id="search-user"
                            placeholder="Tìm kiếm khách hàng..."
                            style="padding-left: 38px; height: 42px; font-size: 15px; border-radius: 10px;">
                        <span
                            style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#bdbdbd;font-size:18px;pointer-events:none;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>
                <ul class="list-group" id="user-list" style="border-radius: 16px; overflow: hidden;">
                    @foreach ($users as $user)
                        <li class="list-group-item user-item d-flex align-items-center gap-2 py-2 px-2 border-0"
                            data-user-id="{{ $user->id }}"
                            style="cursor:pointer; border-bottom:1px solid #f0f0f0; transition: background 0.2s;">
                            <img src="{{ $user->avatar ? asset($user->avatar) : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png' }}"
                                alt="avatar"
                                style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid #e5e7eb;box-shadow:0 1px 2px #0001;">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <b style="font-size:15px;">{{ $user->name }}</b>
                                    <span class="text-muted" style="font-size:12px;"
                                        id="last-time-{{ $user->id }}"></span>
                                </div>
                                <div class="text-muted"
                                    style="font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px;"
                                    id="last-msg-{{ $user->id }}"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- Khung chat -->
            <div class="col-md-9 d-flex flex-column" style="height: 100%;">
                <div class="border-bottom py-2 px-3 d-flex align-items-center gap-3" id="chat-header">
                    <img id="chat-user-avatar"
                        src="https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png"
                        style="width:38px;height:38px;border-radius:50%;border:2px solid #fff;object-fit:cover;display:none;">
                    <span id="chat-with" class="fw-bold" style="font-size:18px;">Chọn khách hàng để chat</span>
                    <button id="toggle-sidebar-btn"
                        class="btn btn-light rounded-circle ms-auto d-flex align-items-center justify-content-center"
                        style="width:34px;height:34px;" title="Thu gọn danh sách khách hàng">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
                <div class="flex-grow-1 px-3 py-2" id="chat-messages" style="overflow-y: auto; background: #f8f9fa;"></div>
                <form id="chat-form" class="d-flex p-3 border-top" style="background: #fff;">
                    <input type="text" id="chat-input" class="form-control me-2" placeholder="Nhập tin nhắn..."
                        autocomplete="off" disabled>
                    <button type="submit" class="btn btn-primary" disabled>Gửi</button>
                </form>
            </div>
        </div>
    </div>
    <meta name="admin-id" content="{{ auth()->id() }}">
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script>
        const userIds = @json($users->pluck('id'));
        let selectedUserId = null;
        let adminId = document.querySelector('meta[name="admin-id"]').getAttribute('content');
        let chatInput = document.getElementById('chat-input');
        let chatForm = document.getElementById('chat-form');
        let chatMessages = document.getElementById('chat-messages');
        let chatWith = document.getElementById('chat-with');
        let sendBtn = chatForm.querySelector('button');

        document.querySelectorAll('.user-item').forEach(item => {
            item.addEventListener('click', function() {
                selectedUserId = this.getAttribute('data-user-id');
                const name = this.querySelector('b').textContent;
                const avatar = this.querySelector('img').getAttribute('src');
                chatWith.innerHTML = `<span class='fw-bold'>${name}</span>`;
                document.getElementById('chat-user-avatar').src = avatar;
                document.getElementById('chat-user-avatar').style.display = '';
                chatInput.disabled = false;
                sendBtn.disabled = false;
                loadConversation(selectedUserId);
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
            div.className = `d-flex mb-2 ${isAdmin ? 'justify-content-end' : 'justify-content-start'}`;
            div.innerHTML = `
                <div style="max-width: 75%; display: flex; align-items: flex-end; gap: 8px;">
                    ${!isAdmin ? `<img src='${userAvatar}' style='width:32px;height:32px;border-radius:50%;border:2px solid #fff;box-shadow:0 1px 2px #0001;object-fit:cover;'/>` : ''}
                    <div style="display: flex; flex-direction: column; align-items: ${isAdmin ? 'flex-end' : 'flex-start'};">
                        <span style="font-size: 13px; color: #888; font-weight: 500; margin-bottom: 2px;">${isAdmin ? 'Admin' : (msg.from_name || 'Khách')}</span>
                        <span style="display: inline-block; padding: 10px 16px; border-radius: 18px 18px 4px 18px; font-size: 15px; background: ${isAdmin ? 'linear-gradient(135deg, #3b82f6, #60a5fa)' : '#fff'}; color: ${isAdmin ? '#fff' : '#232946'}; box-shadow: 0 2px 8px rgba(60,60,60,0.08); word-break: break-word; border:1px solid #e5e7eb;">${msg.message}</span>
                        <span style="font-size:11px;color:#aaa;margin-top:2px;">${time}</span>
                    </div>
                    ${isAdmin ? `<img src='${adminAvatar}' style='width:32px;height:32px;border-radius:50%;border:2px solid #fff;box-shadow:0 1px 2px #0001;object-fit:cover;'/>` : ''}
                </div>
            `;
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
        // Khi nhận realtime, cập nhật last message/time
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
            if (!document.querySelector('.user-item[data-user-id="' + data.from_id + '"]')) {
                let user = data.user || {
                    id: data.from_id,
                    name: data.from_name,
                    avatar: data.avatar ||
                        'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png'
                };
                let li = document.createElement('li');
                li.className = 'list-group-item user-item d-flex align-items-center gap-2 py-2 px-2 border-0';
                li.setAttribute('data-user-id', user.id);
                li.style.cursor = 'pointer';
                li.style.borderBottom = '1px solid #f0f0f0';
                li.innerHTML = `
                    <img src="${user.avatar}" alt="avatar" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid #e5e7eb;box-shadow:0 1px 2px #0001;">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <b style="font-size:15px;">${user.name}</b>
                            <span class="text-muted" style="font-size:12px;" id="last-time-${user.id}"></span>
                        </div>
                        <div class="text-muted" style="font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px;" id="last-msg-${user.id}"></div>
                    </div>
                `;
                document.getElementById('user-list').prepend(li);
                li.addEventListener('click', function() {
                    document.querySelectorAll('.user-item').forEach(i => i.classList.remove('active-user'));
                    this.classList.add('active-user');
                    selectedUserId = user.id;
                    chatWith.innerHTML = `<span class='fw-bold'>${user.name}</span>`;
                    document.getElementById('chat-user-avatar').src = user.avatar;
                    document.getElementById('chat-user-avatar').style.display = '';
                    chatInput.disabled = false;
                    sendBtn.disabled = false;
                    loadConversation(user.id);
                });
            }
            updateSidebarLastMsg(data.from_id, data.message, new Date());
        });
        @foreach ($users as $user)
            var channelName = 'chat-user-{{ $user->id }}';
            var channel = pusher.subscribe(channelName);
            channel.bind('chat-message', function(data) {
                if (selectedUserId == data.from_id) {
                    appendMessage(data, false);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                } else {}
            });
        @endforeach

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!selectedUserId) return;
            let message = chatInput.value.trim();
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
            chatInput.value = '';
        });

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
                            document.getElementById('user-list').innerHTML = newList.innerHTML;
                        }
                    });
            }, 300);
        });
        document.querySelectorAll('.user-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.user-item').forEach(i => i.classList.remove('active-user'));
                this.classList.add('active-user');
            });
        });
        const style = document.createElement('style');
        style.innerHTML = `.user-item.active-user { background: #e0e7ff !important; border-left: 4px solid #3b82f6; }`;
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

        const sidebar = document.querySelector('.col-md-3');
        const chatCol = document.querySelector('.col-md-9');
        const toggleSidebarBtn = document.getElementById('toggle-sidebar-btn');
        let sidebarHidden = false;
        toggleSidebarBtn.onclick = function() {
            sidebarHidden = !sidebarHidden;
            if (sidebarHidden) {
                sidebar.style.display = 'none';
                chatCol.classList.remove('col-md-9');
                chatCol.classList.add('col-md-12');
                toggleSidebarBtn.innerHTML = '<i class="fa-solid fa-bars-staggered"></i>';
            } else {
                sidebar.style.display = '';
                chatCol.classList.remove('col-md-12');
                chatCol.classList.add('col-md-9');
                toggleSidebarBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
            }
        };
    </script>
@endsection
