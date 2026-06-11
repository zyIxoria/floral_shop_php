@extends('layouts.app')

@section('title', 'Giỏ Hàng')

@section('content')
<div class="container-fluid px-4 py-5">
    <h2 class="fw-bold mb-4">Giỏ Hàng</h2>

    <div class="row">
        <div class="col-lg-8">
            @if($cart->items->count() > 0)
            <div class="table-responsive">
                <table class="table border-0">
                    <thead class="border-bottom align-middle">
                        <tr>
                            <th>Sản Phẩm</th>
                            <th>Giá</th>
                            <th class="text-center">Số Lượng</th>
                            <th>Tổng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach($cart->items as $item)
                        <tr class="border-bottom">
                            <td>
                                <div class="d-flex gap-3 align-items-center">
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                         style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                    <div>
                                        <a href="{{ route('products.show', $item->product->slug) }}" class="text-decoration-none fw-bold">
                                            {{ $item->product->name }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td><span class="price-amount" data-vnd="{{ $item->product->getCurrentPrice() }}">{{ number_format($item->product->getCurrentPrice()) }}đ</span></td>
                            <td>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group input-group-sm flex-nowrap mx-auto" style="width: 110px;">
                                        <button class="btn btn-outline-secondary px-2" type="button" 
                                                onclick="if(this.form.quantity.value > 1) { this.form.quantity.value--; this.form.submit(); }">-</button>
                                        <input type="text" name="quantity" value="{{ $item->quantity }}" class="form-control text-center px-1" style="min-width: 40px;" readonly>
                                        <button class="btn btn-outline-secondary px-2" type="button" 
                                                onclick="this.form.quantity.value++; this.form.submit()">+</button>
                                    </div>
                                </form>
                            </td>
                            <td class="fw-bold"><span class="price-amount" data-vnd="{{ $item->getTotal() }}">{{ number_format($item->getTotal()) }}đ</span></td>
                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">
                Giỏ hàng của bạn trống. <a href="{{ route('shop') }}">Tiếp tục mua sắm</a>
            </div>
            @endif
        </div>

        <!-- Cart Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Tóm Tắt Đơn Hàng</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm Tính:</span>
                        <span class="fw-bold price-amount" data-vnd="{{ $cart->getTotalPrice() }}">{{ number_format($cart->getTotalPrice()) }}đ</span>
                    </div>

                    <div class="mb-4 pb-4 border-bottom">
                        <form id="couponForm" class="d-flex gap-2">
                            <input type="text" name="coupon_code" class="form-control form-control-sm" placeholder="Nhập mã khuyến mại" value="{{ $appliedCoupon ? $appliedCoupon->code : '' }}">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="applyCoupon()">Áp Dụng</button>
                        </form>
                    </div>

                    <div class="d-flex justify-content-between mb-4 pb-3 border-bottom">
                        <span>Giảm Giá:</span>
                        <span class="fw-bold text-danger price-amount" id="discountAmount" data-vnd="{{ $discount }}">{{ $discount > 0 ? number_format($discount) . 'đ' : '0đ' }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Tổng Cộng:</span>
                        <span class="h5 text-primary fw-bold price-amount" id="totalAmount" data-vnd="{{ max(0, $cart->getTotalPrice() - $discount) }}">{{ number_format(max(0, $cart->getTotalPrice() - $discount)) }}đ</span>
                    </div>

                    @if($cart->items->count() > 0)
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100">
                        Tiếp Tục Thanh Toán
                    </a>
                    @else
                    <button class="btn btn-primary w-100" disabled>
                        Tiếp Tục Thanh Toán
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function applyCoupon() {
    const code = document.querySelector('[name=coupon_code]').value;
    if (!code) {
        alert('Vui lòng nhập mã khuyến mại');
        return;
    }

    axios.post('{{ route("checkout.applyCoupon") }}', { coupon_code: code })
        .then(response => {
            let discount = response.data.discount;
            let total = response.data.total;
            
            // Update data attributes for dynamic switcher
            document.getElementById('discountAmount').setAttribute('data-vnd', discount);
            document.getElementById('totalAmount').setAttribute('data-vnd', total);

            let currentCurrency = localStorage.getItem('currency') || 'VND';
            if (currentCurrency === 'USD') {
                let rate = parseFloat(localStorage.getItem('usd_rate') || 0.000041);
                document.getElementById('discountAmount').textContent = '$' + (discount * rate).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                document.getElementById('totalAmount').textContent = '$' + (total * rate).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            } else {
                document.getElementById('discountAmount').textContent = discount.toLocaleString('vi-VN') + 'đ';
                document.getElementById('totalAmount').textContent = total.toLocaleString('vi-VN') + 'đ';
            }
            alert('Áp dụng mã khuyến mại thành công');
        })
        .catch(error => {
            alert(error.response.data.error);
        });
}
</script>
@endsection