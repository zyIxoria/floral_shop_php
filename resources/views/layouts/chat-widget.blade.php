<!-- Live Chat Widget -->
<div id="floral-chat-widget" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; font-family: 'Quicksand', 'Nunito', sans-serif;">
    <!-- Chat Bubble Toggle Button -->
    <button id="chat-toggle-btn" class="d-flex align-items-center justify-content-center shadow-lg position-relative" style="width: 60px; height: 60px; border-radius: 50%; border: none; background: linear-gradient(135deg, #e06a96, #b54670); color: white; cursor: pointer; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
        <i class="bi bi-chat-dots-fill" style="font-size: 26px;"></i>
        <!-- Pulse Ring animation -->
        <span class="chat-pulse-ring" style="position: absolute; width: 100%; height: 100%; border: 3px solid #e06a96; border-radius: 50%; animation: chatPulse 2s infinite; opacity: 0; pointer-events: none;"></span>
        <!-- Unread Badge -->
        <span id="chat-unread-badge" class="badge bg-danger position-absolute" style="top: -2px; right: -2px; border-radius: 50%; font-size: 0.75rem; padding: 4px 7px; display: none;">0</span>
    </button>

    <!-- Chat Box Window -->
    <div id="chat-box-window" class="card shadow-lg d-none" style="position: absolute; bottom: 80px; right: 0; width: 360px; height: 500px; border-radius: 16px; overflow: hidden; border: 1px solid rgba(224, 106, 150, 0.2); transition: all 0.3s ease; transform-origin: bottom right;">
        <!-- Header -->
        <div class="card-header d-flex align-items-center justify-content-between text-white p-3" style="background: linear-gradient(135deg, #e06a96, #b54670); border: none;">
            <div class="d-flex align-items-center gap-2">
                <div class="position-relative">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm text-primary" style="width: 40px; height: 40px;">
                        <i class="bi bi-flower1" style="font-size: 22px;"></i>
                    </div>
                    <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 10px; height: 10px; padding: 0;"></span>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-white" style="font-size: 0.95rem; color: #ffffff !important;">Hỗ trợ Floral Shop</h6>
                    <small class="text-white-50" style="font-size: 0.75rem; opacity: 0.9; color: rgba(255, 255, 255, 0.85) !important;">Đang hoạt động</small>
                </div>
            </div>
            <button id="chat-close-btn" class="btn-close btn-close-white" style="font-size: 0.8rem; box-shadow: none;"></button>
        </div>

        <!-- Chat Body / Message Feed -->
        <div class="card-body p-3 d-flex flex-column" style="background-color: #fcf8fa; overflow-y: auto; flex-grow: 1; height: calc(100% - 130px);">
            <!-- Welcome message -->
            <div class="d-flex gap-2 mb-3 align-items-start">
                <div class="d-flex align-items-center justify-content-center bg-light rounded-circle shadow-sm border text-muted" style="min-width: 32px; height: 32px;">
                    <i class="bi bi-robot" style="font-size: 14px;"></i>
                </div>
                <div class="p-2 rounded-3 text-dark shadow-sm" style="background-color: #fff; max-width: 75%; font-size: 0.85rem; border: 1px solid #f3e5eb;">
                    Chào mừng bạn đến với <strong>Floral Shop</strong>! 🌸 Bạn có thể tự viết tin nhắn hoặc chọn nhanh các câu hỏi mẫu bên dưới để được trợ lý của chúng tôi tư vấn ngay nhé:
                </div>
            </div>

            <!-- Predefined Template Questions -->
            <div id="quick-questions" class="d-flex flex-column gap-2 mb-3">
                <button class="btn btn-outline-primary btn-sm text-start py-2 px-3 quick-q-btn" style="border-radius: 20px; font-size: 0.8rem; border-color: rgba(224, 106, 150, 0.4); color: #b54670; background: white;" data-question="🌸 Cửa hàng có giao hoa hỏa tốc trong 2h không?">
                    🌸 Giao hoa hỏa tốc trong 2h?
                </button>
                <button class="btn btn-outline-primary btn-sm text-start py-2 px-3 quick-q-btn" style="border-radius: 20px; font-size: 0.8rem; border-color: rgba(224, 106, 150, 0.4); color: #b54670; background: white;" data-question="💐 Tôi muốn đặt thiết kế hoa riêng theo yêu cầu">
                    💐 Đặt thiết kế hoa riêng theo yêu cầu
                </button>
                <button class="btn btn-outline-primary btn-sm text-start py-2 px-3 quick-q-btn" style="border-radius: 20px; font-size: 0.8rem; border-color: rgba(224, 106, 150, 0.4); color: #b54670; background: white;" data-question="💳 Phương thức thanh toán của shop là gì?">
                    💳 Phương thức thanh toán của shop?
                </button>
                <button class="btn btn-outline-primary btn-sm text-start py-2 px-3 quick-q-btn" style="border-radius: 20px; font-size: 0.8rem; border-color: rgba(224, 106, 150, 0.4); color: #b54670; background: white;" data-question="📦 Chính sách bảo hành và đổi trả hoa thế nào?">
                    📦 Chính sách bảo hành và đổi trả?
                </button>
            </div>

            <!-- Main Message Container -->
            <div id="messages-container" class="d-flex flex-column gap-2 flex-grow-1" style="min-height: 50px;"></div>
        </div>

        <!-- Chat Input Area -->
        <div class="card-footer p-2 bg-white border-top d-flex align-items-center gap-1">
            <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." class="form-control border-0" style="font-size: 0.85rem; box-shadow: none;" autocomplete="off">
            <button id="chat-send-btn" class="btn btn-primary d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; padding: 0; background: #e06a96;">
                <i class="bi bi-send-fill" style="font-size: 14px;"></i>
            </button>
        </div>
    </div>
</div>

<style>
@keyframes chatPulse {
    0% {
        transform: scale(0.95);
        opacity: 0.8;
    }
    50% {
        opacity: 0.3;
    }
    100% {
        transform: scale(1.4);
        opacity: 0;
    }
}
.chat-pulse-active {
    animation: chatPulse 2s infinite !important;
}
.chat-message-bubble {
    animation: bubbleFadeIn 0.3s ease-out forwards;
}
@keyframes bubbleFadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate/retrieve Session ID
    @auth
        const currentUserId = "{{ auth()->id() }}";
        let chatSessionId = 'user_' + currentUserId;
        localStorage.setItem('floral_chat_session', chatSessionId);
    @else
        let chatSessionId = localStorage.getItem('floral_chat_session');
        if (!chatSessionId || chatSessionId.startsWith('user_')) {
            chatSessionId = 'sess_' + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
            localStorage.setItem('floral_chat_session', chatSessionId);
        }
    @endauth

    const chatToggleBtn = document.getElementById('chat-toggle-btn');
    const chatBoxWindow = document.getElementById('chat-box-window');
    const chatCloseBtn = document.getElementById('chat-close-btn');
    const chatSendBtn = document.getElementById('chat-send-btn');
    const chatInput = document.getElementById('chat-input');
    const messagesContainer = document.getElementById('messages-container');
    const chatUnreadBadge = document.getElementById('chat-unread-badge');
    const quickQuestions = document.getElementById('quick-questions');

    let pollInterval = null;
    let badgeInterval = null;
    let isWindowOpen = false;
    let displayedMessageIds = new Set();
    let currentSessionId = '';

    // Toggle chat window
    chatToggleBtn.addEventListener('click', function() {
        isWindowOpen = !isWindowOpen;
        if (isWindowOpen) {
            chatBoxWindow.classList.remove('d-none');
            chatToggleBtn.style.transform = 'scale(0.9)';
            chatUnreadBadge.style.display = 'none';
            chatUnreadBadge.innerText = '0';
            loadMessages();
            startPolling();
        } else {
            closeChat();
        }
    });

    chatCloseBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        closeChat();
    });

    function closeChat() {
        isWindowOpen = false;
        chatBoxWindow.classList.add('d-none');
        chatToggleBtn.style.transform = 'scale(1)';
        stopPolling();
        startBadgePolling();
    }

    // Load messages from database
    function loadMessages() {
        axios.get('/chat/messages', {
            params: { session_id: chatSessionId }
        })
        .then(function(response) {
            if (response.data.status === 'success') {
                renderMessages(response.data.messages);
            }
        })
        .catch(function(error) {
            console.error('Error loading chat messages:', error);
        });
    }

    // Render messages to DOM
    function renderMessages(messages) {
        // If session changed, clear and reset
        if (currentSessionId !== chatSessionId) {
            messagesContainer.innerHTML = '';
            displayedMessageIds.clear();
            currentSessionId = chatSessionId;
        }

        if (messages.length > 0) {
            // Hide template questions if there are customer messages
            quickQuestions.style.display = 'none';
        } else {
            quickQuestions.style.display = 'flex';
            messagesContainer.innerHTML = '';
            displayedMessageIds.clear();
            return;
        }

        let hasNewMessages = false;

        messages.forEach(function(msg) {
            if (displayedMessageIds.has(msg.id)) {
                return; // Already rendered
            }
            displayedMessageIds.add(msg.id);
            hasNewMessages = true;

            const isCustomer = msg.sender_type === 'customer';
            const outerDiv = document.createElement('div');
            outerDiv.className = `d-flex gap-2 mb-2 align-items-start chat-message-bubble ${isCustomer ? 'justify-content-end' : ''}`;
            
            let avatarHtml = '';
            if (!isCustomer) {
                const isBot = msg.sender_name === 'Trợ lý ảo Floral';
                avatarHtml = `
                    <div class="d-flex align-items-center justify-content-center rounded-circle shadow-sm border text-white" 
                         style="min-width: 32px; height: 32px; background: ${isBot ? '#98d8c8' : '#e06a96'}; font-size: 13px;">
                        <i class="bi ${isBot ? 'bi-robot' : 'bi-person-badge-fill'}"></i>
                    </div>
                `;
            }

            const timeStr = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            const bubbleHtml = `
                <div class="p-2 rounded-3 shadow-sm" 
                     style="background-color: ${isCustomer ? '#e06a96' : '#ffffff'}; 
                            color: ${isCustomer ? '#ffffff' : '#333333'}; 
                            max-width: 75%; 
                            font-size: 0.85rem; 
                            border: ${isCustomer ? 'none' : '1px solid #f3e5eb'};">
                    <div class="fw-bold mb-1" style="font-size: 0.7rem; opacity: 0.85;">${msg.sender_name}</div>
                    <div>${msg.message}</div>
                    <div class="text-end mt-1" style="font-size: 0.65rem; opacity: 0.7;">${timeStr}</div>
                </div>
            `;

            if (isCustomer) {
                outerDiv.innerHTML = bubbleHtml;
            } else {
                outerDiv.innerHTML = avatarHtml + bubbleHtml;
            }

            messagesContainer.appendChild(outerDiv);
        });
        
        if (hasNewMessages) {
            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            const parentBody = messagesContainer.parentElement;
            parentBody.scrollTop = parentBody.scrollHeight;
        }
    }

    // Send Message
    function sendMessage(text) {
        if (!text || text.trim() === '') return;
        
        axios.post('/chat/send', {
            session_id: chatSessionId,
            message: text
        })
        .then(function(response) {
            if (response.data.status === 'success') {
                chatInput.value = '';
                loadMessages();
            }
        })
        .catch(function(error) {
            console.error('Error sending chat message:', error);
        });
    }

    // Send on click
    chatSendBtn.addEventListener('click', function() {
        sendMessage(chatInput.value);
    });

    // Send on Enter
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage(chatInput.value);
        }
    });

    // Handle template quick question click
    document.querySelectorAll('.quick-q-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const question = btn.getAttribute('data-question');
            sendMessage(question);
        });
    });

    // Polling functions
    function startPolling() {
        stopPolling();
        pollInterval = setInterval(loadMessages, 3000);
    }

    function stopPolling() {
        if (pollInterval) {
            clearInterval(pollInterval);
            pollInterval = null;
        }
    }

    // Badge notification polling (when window is closed)
    function startBadgePolling() {
        stopBadgePolling();
        badgeInterval = setInterval(checkUnreadCount, 8000);
        checkUnreadCount(); // Immediate check
    }

    function stopBadgePolling() {
        if (badgeInterval) {
            clearInterval(badgeInterval);
            badgeInterval = null;
        }
    }

    function checkUnreadCount() {
        if (isWindowOpen) return;
        axios.get('/chat/unread', {
            params: { session_id: chatSessionId }
        })
        .then(function(response) {
            if (response.data.status === 'success') {
                const count = response.data.unread_count;
                if (count > 0) {
                    chatUnreadBadge.innerText = count;
                    chatUnreadBadge.style.display = 'block';
                    // Optional visual wiggle/pulsing ring activation
                    const ring = chatToggleBtn.querySelector('.chat-pulse-ring');
                    if (ring) ring.classList.add('chat-pulse-active');
                } else {
                    chatUnreadBadge.style.display = 'none';
                    const ring = chatToggleBtn.querySelector('.chat-pulse-ring');
                    if (ring) ring.classList.remove('chat-pulse-active');
                }
            }
        })
        .catch(function(error) {
            console.error('Error fetching unread count:', error);
        });
    }

    // Start checking badge on page load
    startBadgePolling();
});
</script>
