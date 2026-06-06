@extends('layouts.app')

@section('title', 'Thanh Toán')

@section('content')
@php
    $cartTotal = auth()->user()->cart->getTotalPrice();
    $formattedCartTotal = number_format($cartTotal) . ' VND';
@endphp

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
                            <input type="tel" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror" value="{{ old('shipping_phone', $user->phone) }}" required>
                            @error('shipping_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tỉnh/Thành phố *</label>
                            <select name="address_city" class="form-select @error('address_city') is-invalid @enderror" required>
                                <option value="">Chọn Tỉnh/Thành phố</option>
                                <option value="Hà Nội" {{ old('address_city') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                <option value="TP Hồ Chí Minh" {{ old('address_city') == 'TP Hồ Chí Minh' ? 'selected' : '' }}>TP Hồ Chí Minh</option>
                                <option value="Đà Nẵng" {{ old('address_city') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                <option value="Hải Phòng" {{ old('address_city') == 'Hải Phòng' ? 'selected' : '' }}>Hải Phòng</option>
                                <option value="Cần Thơ" {{ old('address_city') == 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                                <option value="Khác" {{ old('address_city') == 'Khác' ? 'selected' : '' }}>Tỉnh thành khác</option>
                            </select>
                            @error('address_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Quận/Huyện *</label>
                            <input type="text" name="address_district" class="form-control @error('address_district') is-invalid @enderror" value="{{ old('address_district') }}" required placeholder="Ví dụ: Quận 1, Huyện Bình Chánh...">
                            @error('address_district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Phường/Xã *</label>
                            <input type="text" name="address_ward" class="form-control @error('address_ward') is-invalid @enderror" value="{{ old('address_ward') }}" required placeholder="Ví dụ: Phường Bến Nghé, Xã Bình Hưng...">
                            @error('address_ward')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số nhà, Tên đường *</label>
                            <input type="text" name="address_street" class="form-control @error('address_street') is-invalid @enderror" value="{{ old('address_street') }}" required placeholder="Ví dụ: 123 Đường Lê Lợi">
                            @error('address_street')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                <label class="form-check-label fw-bold" for="bank_transfer">
                                    Chuyển Khoản Giả Lập
                                </label>
                            </div>

                            <div class="bank-transfer-box mt-3 d-none" id="bankTransferBox">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-4">
                                        <div class="qr-frame">
                                            <img src="{{ asset('assets/payment/qrcode.png') }}"
                                                 alt="QR chuyển khoản"
                                                 class="img-fluid"
                                                 id="paymentQrImage">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <span class="text-muted">Số tài khoản:</span>
                                            <strong class="fs-5 ms-2 text-primary">225515233865</strong>
                                        </div>
                                        <p class="mb-2 text-muted">Số tiền cần thanh toán</p>
                                        <div class="payment-amount">{{ $formattedCartTotal }}</div>
                                        <div class="payment-note mt-3">
                                            Nội dung chuyển khoản:
                                            <strong>FLORAL-{{ auth()->id() }}-{{ now()->format('His') }}</strong>
                                        </div>
                                    </div>
                                </div>
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
                        <span class="fw-bold">{{ number_format($item->getTotal()) }} VND</span>
                    </div>
                    @endforeach

                    <div class="d-flex justify-content-between mb-2 pt-3">
                        <span>Tạm Tính:</span>
                        <span class="fw-bold">{{ $formattedCartTotal }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span>Phí Vận Chuyển:</span>
                        <span class="fw-bold">Miễn Phí</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Tổng Cộng:</span>
                        <span class="h5 text-primary fw-bold">{{ $formattedCartTotal }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bank-transfer-box {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: #fff;
        padding: 1rem;
    }

    .qr-frame {
        align-items: center;
        background: var(--light-color);
        border: 1px dashed var(--border-color);
        border-radius: 8px;
        display: flex;
        justify-content: center;
        min-height: 190px;
        overflow: hidden;
        padding: 0.75rem;
    }

    .qr-frame img {
        max-height: 180px;
        object-fit: contain;
    }

    .qr-missing {
        color: #666;
        font-size: 0.9rem;
        text-align: center;
    }

    .payment-amount {
        color: var(--primary-color);
        font-size: 1.75rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .payment-note {
        background: rgba(152, 216, 200, 0.22);
        border-radius: 8px;
        color: var(--dark-color);
        padding: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const bankTransferBox = document.getElementById('bankTransferBox');
        const paymentQrImage = document.getElementById('paymentQrImage');
        const paymentQrMissing = document.getElementById('paymentQrMissing');

        if (!paymentMethods.length || !bankTransferBox) {
            return;
        }

        const toggleBankTransfer = function () {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            const isBankTransfer = selectedMethod?.value === 'bank_transfer';
            bankTransferBox.classList.toggle('d-none', !isBankTransfer);
            
            const submitBtn = document.querySelector('#checkoutForm button[type="submit"]');
            if(isBankTransfer) {
                submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Tôi Đã Chuyển Khoản (Hoàn Tất Đặt Hàng)';
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-success');
            } else {
                submitBtn.innerHTML = 'Đặt Hàng';
                submitBtn.classList.remove('btn-success');
                submitBtn.classList.add('btn-primary');
            }
        };

        paymentMethods.forEach(function (method) {
            method.addEventListener('change', toggleBankTransfer);
        });

        if (paymentQrImage && paymentQrMissing) {
            paymentQrImage.addEventListener('error', function () {
                paymentQrImage.classList.add('d-none');
                paymentQrMissing.classList.remove('d-none');
            });
        }

        toggleBankTransfer();
    });
</script>
@endpush
