@extends('layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Đơn hàng</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Quản lý Đơn hàng</h3>
            <p class="text-muted">Tổng cộng: <strong>{{ $orders->total() }}</strong> đơn hàng</p>
        </div>
    </div>
    
    <!-- Filter Status -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <span class="badge bg-warning p-2" style="font-size: 0.9rem;">
                        <i class="bi bi-clock"></i> Chờ xử lý: {{ $statusCounts['pending'] ?? 0 }}
                    </span>
                </div>
                <div class="col-md-3">
                    <span class="badge bg-info p-2" style="font-size: 0.9rem;">
                        <i class="bi bi-check-circle"></i> Xác nhận: {{ $statusCounts['confirmed'] ?? 0 }}
                    </span>
                </div>
                <div class="col-md-3">
                    <span class="badge bg-primary p-2" style="font-size: 0.9rem;">
                        <i class="bi bi-truck"></i> Vận chuyển: {{ $statusCounts['shipped'] ?? 0 }}
                    </span>
                </div>
                <div class="col-md-3">
                    <span class="badge bg-success p-2" style="font-size: 0.9rem;">
                        <i class="bi bi-box-seam-check"></i> Đã giao: {{ $statusCounts['delivered'] ?? 0 }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Orders Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày đặt</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $order->user->name ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $order->items_sum_quantity ?? 0 }} sp</span>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($order->total, 0, ',', '.') }} ₫</strong>
                                    </td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning"><i class="bi bi-clock"></i> Chờ xử lý</span>
                                        @elseif($order->status == 'confirmed')
                                            <span class="badge bg-info"><i class="bi bi-check-circle"></i> Xác nhận</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-primary"><i class="bi bi-truck"></i> Vận chuyển</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge bg-success"><i class="bi bi-box-seam-check"></i> Đã giao</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Hủy</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
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
    
    <!-- Pagination -->
    @if($orders->count() > 0)
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
