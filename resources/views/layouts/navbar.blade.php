<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
            <i class="bi bi-flower1"></i> Floral Shop
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Currency Switcher -->
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle py-1 px-2 border rounded d-flex align-items-center gap-1" href="#" id="currencyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.9rem;">
                        <i class="bi bi-currency-exchange"></i> <span id="currentCurrencyLabel">VND (đ)</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="currencyDropdown">
                        <li><a class="dropdown-item" href="#" onclick="changeCurrency('VND'); return false;">VND (đ)</a></li>
                        <li><a class="dropdown-item" href="#" onclick="changeCurrency('USD'); return false;">USD ($)</a></li>
                    </ul>
                </li>
                
                <!-- Notification Bell -->
                @auth
                    @php
                        $notifications = [];
                        $unreadCount = 0;
                        
                        if (auth()->user()->isAdmin()) {
                            // 1. Pending orders
                            $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
                            if ($pendingOrdersCount > 0) {
                                $notifications[] = [
                                    'icon' => 'bi-bag-fill text-warning',
                                    'text' => "Có {$pendingOrdersCount} đơn hàng mới chờ xử lý",
                                    'link' => route('admin.orders.index'),
                                    'onclick' => ''
                                ];
                                $unreadCount += $pendingOrdersCount;
                            }
                            
                            // 2. Unread customer chat sessions
                            $unreadChatsCount = \App\Models\ChatMessage::where('sender_type', 'customer')
                                ->where('is_read_by_admin', false)
                                ->distinct('session_id')
                                ->count('session_id');
                            if ($unreadChatsCount > 0) {
                                $notifications[] = [
                                    'icon' => 'bi-chat-dots-fill text-info',
                                    'text' => "Có {$unreadChatsCount} cuộc chat mới từ khách hàng",
                                    'link' => route('admin.chats.index'),
                                    'onclick' => ''
                                ];
                                $unreadCount += $unreadChatsCount;
                            }
                        } else {
                            // 1. Unread chat messages from admin
                            $customerUnreadChats = \App\Models\ChatMessage::where('sender_type', 'admin')
                                ->where('is_read_by_customer', false)
                                ->where('user_id', auth()->id())
                                ->count();
                            if ($customerUnreadChats > 0) {
                                $notifications[] = [
                                    'icon' => 'bi-chat-dots-fill text-info',
                                    'text' => "Bạn có tin nhắn hỗ trợ mới",
                                    'link' => '#',
                                    'onclick' => "const btn = document.getElementById('chat-toggle-btn'); if(btn) { btn.click(); } return false;"
                                ];
                                $unreadCount += $customerUnreadChats;
                            }
                            
                            // 2. Recent orders updates
                            $recentOrders = \App\Models\Order::where('user_id', auth()->id())
                                ->whereIn('status', ['confirmed', 'shipped', 'delivered'])
                                ->where('updated_at', '>=', now()->subDays(5))
                                ->orderByDesc('updated_at')
                                ->limit(5)
                                ->get();
                            foreach ($recentOrders as $order) {
                                $statusText = match($order->status) {
                                    'confirmed' => 'được xác nhận',
                                    'shipped' => 'đang vận chuyển',
                                    'delivered' => 'đã giao thành công',
                                    default => ''
                                };
                                $notifications[] = [
                                    'icon' => 'bi-check-circle-fill text-success',
                                    'text' => "Đơn hàng #{$order->id} {$statusText}",
                                    'link' => route('profile.orders'),
                                    'onclick' => ''
                                ];
                            }
                        }
                    @endphp
                    
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link position-relative py-1 px-2 border rounded d-flex align-items-center justify-content-center" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px; border-radius: 8px !important;">
                            <i class="bi bi-bell" style="font-size: 1.15rem;"></i>
                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; padding: 0.25em 0.5em; margin-top: 4px; margin-left: -4px;">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2 mt-2" aria-labelledby="notificationDropdown" style="width: 280px; max-height: 350px; overflow-y: auto; border-radius: 12px;">
                            <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark">Thông báo</span>
                                @if($unreadCount > 0)
                                    <span class="badge bg-soft-danger text-danger rounded-pill" style="font-size: 0.75rem; background-color: rgba(220, 53, 69, 0.1);">{{ $unreadCount }} mới</span>
                                @endif
                            </div>
                            @if(count($notifications) > 0)
                                @foreach($notifications as $notif)
                                    <li>
                                        <a class="dropdown-item py-2 px-3 border-bottom d-flex align-items-start gap-2" href="{{ $notif['link'] }}" @if(!empty($notif['onclick'])) onclick="{!! $notif['onclick'] !!}" @endif style="white-space: normal; font-size: 0.85rem;">
                                            <i class="bi {{ $notif['icon'] }} mt-0.5" style="font-size: 1rem;"></i>
                                            <div class="text-wrap">{{ $notif['text'] }}</div>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <div class="text-center py-4 text-muted" style="font-size: 0.85rem;">
                                    <i class="bi bi-bell-slash d-block mb-2 text-muted" style="font-size: 24px;"></i>
                                    Không có thông báo mới
                                </div>
                            @endif
                        </ul>
                    </li>
                @endauth
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Trang Chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop') }}">Cửa Hàng</a>
                </li>
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.wishlist') }}">
                                <i class="bi bi-heart"></i> Wishlist
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="bi bi-bag"></i> Giỏ Hàng
                                @if(auth()->user()->cart && auth()->user()->cart->getTotalItems() > 0)
                                    <span class="badge bg-danger">{{ auth()->user()->cart->getTotalItems() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Hồ Sơ</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.orders') }}">Đơn Hàng</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item">Đăng Xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Đăng Nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Đăng Ký</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>