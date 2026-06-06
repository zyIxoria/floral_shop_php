<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Floral Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        :root {
            --primary-color: #ff69b4;
            --secondary-color: #98d8c8;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
        }
        
        body {
            background-color: var(--light-color);
        }
        
        .admin-sidebar {
            width: 250px;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--dark-color) 0%, #34495e 100%);
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .admin-sidebar .nav-link {
            color: rgba(255,255,255,0.8) !important;
            padding: 12px 15px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .admin-sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white !important;
            padding-left: 25px;
        }
        
        .admin-sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
            color: white !important;
            font-weight: 600;
        }
        
        .admin-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
        
        .admin-topbar {
            background: white;
            padding: 15px 20px;
            border-bottom: 2px solid var(--primary-color);
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item.active {
            color: var(--dark-color);
            font-weight: 600;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                width: 200px;
            }
            .admin-content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }
        }
        
        @media (max-width: 576px) {
            .admin-sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
            }
            .admin-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="admin-sidebar text-white p-3">
            <div class="d-flex align-items-center mb-4">
                <i class="bi bi-flower1" style="font-size: 28px; margin-right: 10px;"></i>
                <h5 class="fw-bold mb-0">Admin</h5>
            </div>
            
            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                
                <!-- Statistics -->
                <li class="nav-item">
                    <a href="{{ route('admin.statistics') }}" class="nav-link {{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
                        <i class="bi bi-graph-up-arrow"></i> Thống kê
                    </a>
                </li>
                
                <!-- Products -->
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-flower2"></i> Sản phẩm
                    </a>
                </li>
                
                <!-- Categories -->
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tag"></i> Danh mục
                    </a>
                </li>
                
                <!-- Orders -->
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-bag-check"></i> Đơn hàng
                    </a>
                </li>
                
                <!-- Users -->
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Khách hàng
                    </a>
                </li>
                
                <!-- Coupons -->
                <li class="nav-item">
                    <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i> Mã giảm giá
                    </a>
                </li>

                <!-- Support Chat -->
                <li class="nav-item">
                    <a href="{{ route('admin.chats.index') }}" class="nav-link {{ request()->routeIs('admin.chats.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-square-quote"></i> Hỗ trợ khách hàng
                        @php
                            $unreadChatsCount = \App\Models\ChatMessage::where('sender_type', 'customer')
                                ->where('is_read_by_admin', false)
                                ->distinct('session_id')
                                ->count('session_id');
                        @endphp
                        @if($unreadChatsCount > 0)
                            <span class="badge bg-danger ms-2" style="font-size: 0.7rem;">{{ $unreadChatsCount }}</span>
                        @endif
                    </a>
                </li>
                
                <hr class="my-3" style="opacity: 0.2;">
                
                <!-- Account Section -->
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link">
                        <i class="bi bi-person"></i> Tài khoản
                    </a>
                </li>
                
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-start" style="border: none; background: none;">
                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="admin-content">
            <!-- Top Bar -->
            <div class="admin-topbar">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        @yield('breadcrumbs')
                    </ol>
                </nav>
                
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted">{{ auth()->user()->name }}</span>
                    <i class="bi bi-person-circle" style="font-size: 24px; color: var(--primary-color);"></i>
                </div>
            </div>
            
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> Có lỗi trong biểu mẫu:
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Page Content -->
            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.4.0/dist/axios.min.js"></script>
    @stack('scripts')