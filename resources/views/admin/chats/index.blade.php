@extends('layouts.admin')
 
 @section('title', 'Hỗ trợ khách hàng')
 
 @section('breadcrumbs')
     <li class="breadcrumb-item active">Hỗ trợ khách hàng</li>
 @endsection
 
 @section('content')
 <div class="container-fluid" style="font-family: 'Quicksand', 'Nunito', sans-serif;">
     <div class="row">
         <!-- Left Pane: Conversations List -->
         <div class="col-lg-4 col-md-5 mb-4">
             <div class="card border-0 shadow-sm" style="height: calc(100vh - 180px); display: flex; flex-direction: column;">
                 <div class="card-header bg-white border-bottom py-3">
                     <h5 class="fw-bold mb-2 text-primary d-flex align-items-center gap-2">
                         <i class="bi bi-chat-left-text-fill"></i> Hội thoại hỗ trợ
                     </h5>
                     <div class="input-group">
                         <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                         <input type="text" id="search-sessions" class="form-control bg-light border-0" placeholder="Tìm kiếm khách hàng..." style="font-size: 0.85rem; box-shadow: none;">
                     </div>
                 </div>
                 
                 <!-- Sessions Container -->
                 <div class="card-body p-0 flex-grow-1" id="sessions-list-container" style="overflow-y: auto;">
                     <div class="text-center py-5 text-muted" id="sessions-loading">
                         <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                         <div>Đang tải hội thoại...</div>
                     </div>
                     <div class="list-group list-group-flush d-none" id="sessions-list">
                         <!-- Dynamically populated -->
                     </div>
                 </div>
             </div>
         </div>
 
         <!-- Right Pane: Active Chat Room -->
         <div class="col-lg-8 col-md-7 mb-4">
             <div class="card border-0 shadow-sm" id="chat-window-card" style="height: calc(100vh - 180px); display: flex; flex-direction: column;">
                 <!-- Placeholder (No session selected) -->
                 <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted p-5" id="chat-placeholder">
                     <div class="bg-light rounded-circle p-4 mb-3 d-flex align-items-center justify-content-center text-primary" style="width: 100px; height: 100px;">
                         <i class="bi bi-chat-dots" style="font-size: 48px;"></i>
                     </div>
                     <h5 class="fw-bold mb-1 text-dark">Chưa chọn cuộc trò chuyện</h5>
                     <p class="text-center mb-0" style="max-width: 300px;">Chọn một cuộc hội thoại từ danh sách bên trái để bắt đầu hỗ trợ khách hàng trực tuyến.</p>
                 </div>
 
                 <!-- Chat Window Header -->
                 <div class="card-header bg-white border-bottom py-3 d-none" id="chat-header">
                     <div class="d-flex align-items-center justify-content-between">
                         <div class="d-flex align-items-center gap-2">
                             <div class="d-flex align-items-center justify-content-center rounded-circle text-white shadow-sm fw-bold" 
                                  id="active-user-avatar" style="width: 45px; height: 45px; background: linear-gradient(135deg, #e06a96, #b54670); font-size: 1.1rem;">
                                 K
                             </div>
                             <div>
                                 <h6 class="mb-0 fw-bold" id="active-user-name">Tên khách hàng</h6>
                                 <small class="text-success d-flex align-items-center gap-1">
                                     <span class="bg-success rounded-circle" style="width: 8px; height: 8px; display: inline-block;"></span>
                                     Đang trực tuyến
                                 </small>
                             </div>
                         </div>
                         <div class="text-muted" id="active-session-id-display" style="font-size: 0.75rem;">
                             ID: sess_xxxx
                         </div>
                     </div>
                 </div>
 
                 <!-- Message Thread Container -->
                 <div class="card-body p-3 d-none" id="chat-messages-container" style="background-color: #fbf8f9; overflow-y: auto; flex-grow: 1;">
                     <!-- Dynamically populated -->
                 </div>
 
                 <!-- Chat Input Panel -->
                 <div class="card-footer bg-white border-top p-3 d-none" id="chat-input-panel">
                     <div class="input-group">
                         <input type="text" id="admin-message-input" class="form-control border-light py-2 px-3 bg-light" 
                                placeholder="Nhập tin nhắn phản hồi..." style="font-size: 0.9rem; border-radius: 20px 0 0 20px; box-shadow: none;">
                         <button class="btn btn-primary px-4 d-flex align-items-center justify-content-center" 
                                 id="admin-send-btn" style="border-radius: 0 20px 20px 0; background: linear-gradient(135deg, #e06a96, #b54670); border: none;">
                             <i class="bi bi-send-fill me-1"></i> Gửi
                         </button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 
 <style>
 .session-item {
     border-left: 4px solid transparent;
     transition: all 0.2s ease;
     cursor: pointer;
 }
 .session-item:hover {
     background-color: #f8f9fa;
 }
 .session-item.active {
     background-color: #f0f3f6 !important;
     border-left-color: #e06a96 !important;
 }
 .admin-message-bubble {
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
 
 @push('scripts')
 <script>
 document.addEventListener('DOMContentLoaded', function() {
     let activeSessionId = null;
     let sessionList = [];
     let unreadCountsTracker = {};
     let isTabActive = true;
     let displayedMessageIds = new Set();
     let currentSessionId = '';
 
     // Handle tab focus to control notifications
     window.addEventListener('blur', () => isTabActive = false);
     window.addEventListener('focus', () => isTabActive = true);
 
     // DOM Elements
     const sessionsLoading = document.getElementById('sessions-loading');
     const sessionsList = document.getElementById('sessions-list');
     const searchInput = document.getElementById('search-sessions');
 
     const chatPlaceholder = document.getElementById('chat-placeholder');
     const chatHeader = document.getElementById('chat-header');
     const chatMessagesContainer = document.getElementById('chat-messages-container');
     const chatInputPanel = document.getElementById('chat-input-panel');
 
     const activeUserAvatar = document.getElementById('active-user-avatar');
     const activeUserName = document.getElementById('active-user-name');
     const activeSessionIdDisplay = document.getElementById('active-session-id-display');
 
     const adminMessageInput = document.getElementById('admin-message-input');
     const adminSendBtn = document.getElementById('admin-send-btn');
 
     // Web Audio API Synthesized double-beep notification sound
     function playNotificationSound() {
         try {
             const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
             const osc = audioCtx.createOscillator();
             const gain = audioCtx.createGain();
             osc.connect(gain);
             gain.connect(audioCtx.destination);
             
             // Soft pleasant notification sound
             osc.type = 'sine';
             osc.frequency.setValueAtTime(587.33, audioCtx.currentTime); // D5
             gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
             osc.start(audioCtx.currentTime);
             
             osc.frequency.setValueAtTime(880, audioCtx.currentTime + 0.1); // A5
             gain.gain.setValueAtTime(0, audioCtx.currentTime + 0.22);
             osc.stop(audioCtx.currentTime + 0.25);
         } catch (e) {
             console.error('Audio synthesis failed:', e);
         }
     }
 
     // Fetch conversations list
     function fetchSessions() {
         axios.get('/admin/chats/sessions')
             .then(function(response) {
                 if (response.data.status === 'success') {
                     sessionList = response.data.sessions;
                     renderSessions();
                 }
             })
             .catch(function(error) {
                 console.error('Error fetching sessions:', error);
             });
     }
 
     // Helper for avatars colors
     const pastelColors = ['#f5c2d5', '#b8e5dd', '#ffdca2', '#d2b4de', '#f5b7b1', '#aed6f1'];
     function getAvatarColor(str) {
         let hash = 0;
         for (let i = 0; i < str.length; i++) {
             hash = str.charCodeAt(i) + ((hash << 5) - hash);
         }
         const index = Math.abs(hash % pastelColors.length);
         return pastelColors[index];
     }
 
     // Render sessions list
     function renderSessions() {
         const searchTerm = searchInput.value.trim().toLowerCase();
         const filteredSessions = sessionList.filter(function(session) {
             const name = session.sender_name.toLowerCase();
             const msg = session.message.toLowerCase();
             const sessId = session.session_id.toLowerCase();
             return name.includes(searchTerm) || msg.includes(searchTerm) || sessId.includes(searchTerm);
         });
 
         sessionsLoading.classList.add('d-none');
         sessionsList.classList.remove('d-none');
 
         let alertTriggered = false;
         let listHtml = '';
 
         filteredSessions.forEach(function(session) {
             const isActive = session.session_id === activeSessionId;
             const isUnread = session.unread_count > 0;
 
             // Notification trigger check
             const prevCount = unreadCountsTracker[session.session_id] || 0;
             if (isUnread && session.unread_count > prevCount && !isActive) {
                 alertTriggered = true;
             }
             unreadCountsTracker[session.session_id] = session.unread_count;
 
             const initial = session.sender_name.charAt(0).toUpperCase();
             const avatarBg = getAvatarColor(session.sender_name);
             const timeStr = new Date(session.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
 
             listHtml += `
                 <a href="#" class="list-group-item list-group-item-action py-3 px-3 session-item ${isActive ? 'active' : ''}" 
                    onclick="selectSession('${session.session_id}', '${session.sender_name}'); return false;">
                     <div class="d-flex align-items-center justify-content-between mb-1">
                         <div class="d-flex align-items-center gap-2">
                             <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white" 
                                  style="width: 36px; height: 36px; background-color: ${avatarBg}; font-size: 0.9rem;">
                                 ${initial}
                             </div>
                             <div>
                                 <strong class="mb-0 text-dark" style="font-size: 0.88rem;">${session.sender_name}</strong>
                                 ${session.session_id.startsWith('user_') ? '<span class="badge bg-secondary ms-1" style="font-size: 0.6rem;">Thành viên</span>' : '<span class="badge bg-light text-muted border ms-1" style="font-size: 0.6rem;">Khách</span>'}
                             </div>
                         </div>
                         <small class="text-muted" style="font-size: 0.7rem;">${timeStr}</small>
                     </div>
                     <div class="d-flex align-items-center justify-content-between ps-5">
                         <span class="text-muted text-truncate" style="font-size: 0.78rem; max-width: 180px; font-weight: ${isUnread ? 'bold' : 'normal'};">
                             ${session.sender_type === 'admin' ? '<span class="text-primary">Bạn: </span>' : ''}${session.message}
                         </span>
                         ${isUnread ? `<span class="badge bg-danger rounded-circle" style="font-size: 0.65rem; padding: 4px 7px;">${session.unread_count}</span>` : ''}
                     </div>
                 </a>
             `;
         });
 
         if (listHtml === '') {
             sessionsList.innerHTML = `<div class="text-center py-5 text-muted" style="font-size: 0.85rem;">Không có cuộc hội thoại nào phù hợp.</div>`;
         } else {
             sessionsList.innerHTML = listHtml;
         }
 
         // Play sound alert if there are new unread messages
         if (alertTriggered) {
             playNotificationSound();
         }
     }
 
     // Handle Session Selection
     window.selectSession = function(sessionId, senderName) {
         activeSessionId = sessionId;
 
         // Reset tracker count for this session
         unreadCountsTracker[sessionId] = 0;
 
         // Visual swap
         chatPlaceholder.classList.add('d-none');
         chatHeader.classList.remove('d-none');
         chatMessagesContainer.classList.remove('d-none');
         chatInputPanel.classList.remove('d-none');
 
         activeUserName.innerText = senderName;
         activeUserAvatar.innerText = senderName.charAt(0).toUpperCase();
         activeUserAvatar.style.backgroundColor = getAvatarColor(senderName);
         activeSessionIdDisplay.innerText = `ID: ${sessionId}`;
 
         loadActiveMessages();
         renderSessions(); // Refresh highlights and badges immediately
     };
 
     // Fetch Active Session Messages
     function loadActiveMessages() {
         if (!activeSessionId) return;
 
         axios.get(`/admin/chats/messages/${activeSessionId}`)
             .then(function(response) {
                 if (response.data.status === 'success') {
                     renderMessages(response.data.messages);
                 }
             })
             .catch(function(error) {
                 console.error('Error fetching chat thread:', error);
             });
     }
 
     // Render Active Messages
     function renderMessages(messages) {
         // If session changed, clear and reset
         if (currentSessionId !== activeSessionId) {
             chatMessagesContainer.innerHTML = '';
             displayedMessageIds.clear();
             currentSessionId = activeSessionId;
         }
 
         let hasNewMessages = false;
 
         messages.forEach(function(msg) {
             if (displayedMessageIds.has(msg.id)) {
                 return; // Already rendered
             }
             displayedMessageIds.add(msg.id);
             hasNewMessages = true;
 
             const isMe = msg.sender_type === 'admin';
             const isBot = msg.sender_name === 'Trợ lý ảo Floral';
 
             const outerDiv = document.createElement('div');
             outerDiv.className = `d-flex gap-2 mb-3 align-items-start admin-message-bubble ${isMe ? 'justify-content-end' : ''}`;
 
             let avatarHtml = '';
             if (!isMe) {
                 avatarHtml = `
                     <div class="d-flex align-items-center justify-content-center rounded-circle border bg-white shadow-sm" 
                          style="min-width: 36px; height: 36px; color: #b54670; font-size: 15px;">
                         <i class="bi bi-person-fill"></i>
                     </div>
                 `;
             }
 
             const timeStr = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
 
             const bubbleHtml = `
                 <div class="p-3 rounded-4 shadow-sm" 
                      style="background-color: ${isMe ? '#e06a96' : '#ffffff'}; 
                             color: ${isMe ? '#ffffff' : '#333333'}; 
                             max-width: 70%; 
                             font-size: 0.85rem; 
                             border: ${isMe ? 'none' : '1px solid rgba(0,0,0,0.05)'};">
                     <div class="fw-bold mb-1" style="font-size: 0.72rem; opacity: 0.85;">
                         ${msg.sender_name} ${isBot ? '<span class="badge bg-success ms-1" style="font-size: 0.55rem; padding: 2px 5px;">Bot</span>' : ''}
                     </div>
                     <div>${msg.message}</div>
                     <div class="text-end mt-1" style="font-size: 0.65rem; opacity: 0.7;">${timeStr}</div>
                 </div>
             `;
 
             if (isMe) {
                 outerDiv.innerHTML = bubbleHtml;
             } else {
                 outerDiv.innerHTML = avatarHtml + bubbleHtml;
             }
 
             chatMessagesContainer.appendChild(outerDiv);
         });
 
         if (hasNewMessages) {
             // Keep scroll at bottom
             chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
         }
     }
 
     // Send Response Reply
     function sendReply() {
         const replyText = adminMessageInput.value.trim();
         if (!replyText || !activeSessionId) return;
 
         axios.post(`/admin/chats/send/${activeSessionId}`, {
             message: replyText
         })
         .then(function(response) {
             if (response.data.status === 'success') {
                 adminMessageInput.value = '';
                 loadActiveMessages();
                 fetchSessions();
             }
         })
         .catch(function(error) {
             console.error('Error sending response:', error);
         });
     }
 
     adminSendBtn.addEventListener('click', sendReply);
     adminMessageInput.addEventListener('keypress', function(e) {
         if (e.key === 'Enter') {
             sendReply();
         }
     });
 
     // Sessions search filtering
     searchInput.addEventListener('input', renderSessions);
 
     // Initial run
     fetchSessions();
 
     // Polling loops:
     // 1. Sessions List Polling (Every 3 seconds)
     setInterval(fetchSessions, 3000);
 
     // 2. Active Messages Polling (Every 3 seconds)
     setInterval(function() {
         if (activeSessionId) {
             loadActiveMessages();
         }
     }, 3000);
 });
 </script>
 @endpush
 @endsection
