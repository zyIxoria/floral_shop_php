@extends('layouts.app')

@section('title', 'Đặt Hàng Thành Công')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Đặt Hàng Thành Công!</h2>
                    <p class="text-muted mb-4">Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>
                    
                    <div class="bg-light p-4 rounded text-start mb-4">
                        <h5 class="fw-bold border-bottom pb-2 mb-3">Thông Tin Đơn Hàng</h5>
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Mã đơn hàng:</div>
                            <div class="col-sm-8 fw-bold">#{{ $order->order_number ?? $order->id }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Ngày đặt:</div>
                            <div class="col-sm-8">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Phương thức thanh toán:</div>
                            <div class="col-sm-8">
                                @if($order->payment_method === 'cod')
                                    Thanh toán khi nhận hàng (COD)
                                @elseif($order->payment_method === 'bank_transfer')
                                    Chuyển khoản ngân hàng
                                @elseif($order->payment_method === 'vnpay')
                                    Thanh toán VNPay
                                @else
                                    {{ strtoupper($order->payment_method) }}
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Trạng thái:</div>
                            <div class="col-sm-8">
                                <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-sm-4 text-muted">Tổng thanh toán:</div>
                            <div class="col-sm-8 fw-bold text-danger fs-5"><span class="price-amount" data-vnd="{{ $order->total }}">{{ number_format($order->total, 0, ',', '.') }} ₫</span></div>
                        </div>
                    </div>

                    <div class="bg-light p-4 rounded text-start mb-4">
                        <h5 class="fw-bold border-bottom pb-2 mb-3">Thông Tin Giao Hàng</h5>
                        <p class="mb-1"><strong>Người nhận:</strong> {{ auth()->user()->name }}</p>
                        <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->shipping_phone }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $order->shipping_email }}</p>
                        <p class="mb-0"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <a href="{{ route('profile.orders') }}" class="btn btn-outline-primary">
                            <i class="bi bi-file-earmark-text"></i> Xem Đơn Hàng Của Tôi
                        </a>
                        <a href="{{ route('shop') }}" class="btn btn-primary">
                            <i class="bi bi-cart"></i> Tiếp Tục Mua Sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection