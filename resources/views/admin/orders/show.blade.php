@extends('layouts.admin')

@section('title', 'Chi tiết Đơn hàng')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Đơn hàng</a></li>
    <li class="breadcrumb-item active">Chi tiết #{{ $order->id }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <!-- Order Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Khách hàng</h6>
                            <p class="mb-1"><strong>{{ $order->user->name ?? 'N/A' }}</strong></p>
                            <p class="mb-1 text-muted">{{ $order->user->email ?? 'N/A' }}</p>
                            <p class="mb-0 text-muted">{{ $order->user->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Địa chỉ giao hàng</h6>
                            <p class="mb-0 text-muted">{{ $order->shipping_address ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã đơn:</strong> #{{ $order->id }}</p>
                            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Ghi chú:</strong> {{ $order->notes ?? 'Không có' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Chi tiết sản phẩm</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->items ?? [] as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product->name ?? 'N/A' }}</strong>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price, 0, ',', '.') }} ₫</td>
                                        <td><strong>{{ number_format($item->quantity * $item->price, 0, ',', '.') }} ₫</strong></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Không có sản phẩm</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tổng sản phẩm:</span>
                                <strong>{{ number_format($order->subtotal ?? 0, 0, ',', '.') }} ₫</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển:</span>
                                <strong>{{ number_format($order->shipping_fee ?? 0, 0, ',', '.') }} ₫</strong>
                            </div>
                            @if($order->coupon_discount ?? 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Giảm giá:</span>
                                    <strong class="text-success">-{{ number_format($order->coupon_discount, 0, ',', '.') }} ₫</strong>
                                </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span style="font-size: 1.1rem; font-weight: bold;">Tổng cộng:</span>
                                <strong style="font-size: 1.1rem; color: #ff69b4;">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Status Update -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Trạng thái đơn hàng</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Cập nhật trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                    <i class="bi bi-clock"></i> Chờ xử lý
                                </option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                    <i class="bi bi-check-circle"></i> Xác nhận
                                </option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                    <i class="bi bi-truck"></i> Vận chuyển
                                </option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                    <i class="bi bi-box-seam-check"></i> Đã giao
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                    <i class="bi bi-x-circle"></i> Hủy
                                </option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg"></i> Lưu thay đổi
                        </button>
                    </form>
                    
                    <div class="mt-3">
                        <h6 class="fw-bold mb-2">Trạng thái hiện tại:</h6>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning p-2" style="font-size: 0.9rem;">
                                <i class="bi bi-clock"></i> Chờ xử lý
                            </span>
                        @elseif($order->status == 'confirmed')
                            <span class="badge bg-info p-2" style="font-size: 0.9rem;">
                                <i class="bi bi-check-circle"></i> Xác nhận
                            </span>
                        @elseif($order->status == 'shipped')
                            <span class="badge bg-primary p-2" style="font-size: 0.9rem;">
                                <i class="bi bi-truck"></i> Vận chuyển
                            </span>
                        @elseif($order->status == 'delivered')
                            <span class="badge bg-success p-2" style="font-size: 0.9rem;">
                                <i class="bi bi-box-seam-check"></i> Đã giao
                            </span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger p-2" style="font-size: 0.9rem;">
                                <i class="bi bi-x-circle"></i> Hủy
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
