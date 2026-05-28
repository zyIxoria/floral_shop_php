<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
            <i class="bi bi-flower1"></i> Floral Shop
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
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