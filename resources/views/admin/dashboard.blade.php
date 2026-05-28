@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- Total Revenue -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Doanh thu</p>
                            <h3 class="fw-bold">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-cash-coin text-success" style="font-size: 24px;"></i>
                        </div>
                    </div>
                    <small class="text-success"><i class="bi bi-arrow-up"></i> Từ các đơn hàng đã giao</small>
                </div>
            </div>
        </div>
        
        <!-- Total Orders -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Đơn hàng</p>
                            <h3 class="fw-bold">{{ $totalOrders }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-bag-check text-info" style="font-size: 24px;"></i>
                        </div>
                    </div>
                    <small class="text-info"><i class="bi bi-graph-up"></i> Tất cả các đơn hàng</small>
                </div>
            </div>
        </div>
        
        <!-- Total Users -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Khách hàng</p>
                            <h3 class="fw-bold">{{ $totalUsers }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people text-warning" style="font-size: 24px;"></i>
                        </div>
                    </div>
                    <small class="text-warning"><i class="bi bi-person-plus"></i> Người dùng đã đăng ký</small>
                </div>
            </div>
        </div>
        
        <!-- Total Products -->
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Sản phẩm</p>
                            <h3 class="fw-bold">{{ $totalProducts }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded">
                            <i class="bi bi-flower2 text-danger" style="font-size: 24px;"></i>
                        </div>
                    </div>
                    <small class="text-danger"><i class="bi bi-boxes"></i> Trong cửa hàng</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Đơn hàng gần đây</h5>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                            Xem tất cả <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td class="fw-bold">#{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                                        @break
                                                    @case('confirmed')
                                                        <span class="badge bg-info">Đã xác nhận</span>
                                                        @break
                                                    @case('shipped')
                                                        <span class="badge bg-primary">Đang giao</span>
                                                        @break
                                                    @case('delivered')
                                                        <span class="badge bg-success">Đã giao</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger">Đã hủy</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ number_format($order->total, 0, ',', '.') }} ₫</td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i> Chi tiết
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                            <p class="text-muted mt-3">Chưa có đơn hàng nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush
@endsection