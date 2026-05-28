@extends('layouts.app')

@section('title', 'Thanh Toán')

@section('content')
<div class="container-fluid px-4 py-5">
    <h2 class="fw-bold mb-4">Thanh Toán</h2>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Thông Tin Giao Hàng</h5>

                    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ Tên *</label>
                            <input type="text" name="shipping_name" class="form-control" value="{{ $user->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email *</label>
                            <input type="email" name="shipping_email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số Điện Thoại *</label>
                            <input type="tel" name="shipping_phone" class="form-control" value="{{ $user->phone }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa Chỉ Giao Hàng *</label>
                            <textarea name="shipping_address" class="form-control" rows="3" required>{{ $user->address }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ghi Chú</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Ghi chú thêm cho đơn hàng"></textarea>
                        </div>

                        <h5 class="fw-bold mb-3 mt-4">Phương Thức Thanh Toán</h5>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label fw-bold" for="cod">
                                    Thanh Toán Khi Nhận Hàng (COD)
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="vnpay" value="vnpay">
                                <label class="form-check-label fw-bold" for="vnpay">
                                    Thanh Toán Qua VNPay
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            Đặt Hàng
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Tóm Tắt Đơn Hàng</h5>

                    @foreach(auth()->user()->cart->items as $item)
                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                        <div>
                            <p class="mb-0">{{ $item->product->name }}</p>
                            <small class="text-muted">x{{ $item->quantity }}</small>
                        </div>
                        <span class="fw-bold">{{ number_format($item->getTotal()) }}đ</span>
                    </div>
                    @endforeach

                    <div class="d-flex justify-content-between mb-2 pt-3">
                        <span>Tạm Tính:</span>
                        <span class="fw-bold">{{ number_format(auth()->user()->cart->getTotalPrice()) }}đ</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span>Phí Vận Chuyển:</span>
                        <span class="fw-bold">Miễn Phí</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Tổng Cộng:</span>
                        <span class="h5 text-primary fw-bold">{{ number_format(auth()->user()->cart->getTotalPrice()) }}đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection