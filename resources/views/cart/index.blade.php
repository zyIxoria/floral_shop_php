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
                    <thead class="border-bottom">
                        <tr>
                            <th>Sản Phẩm</th>
                            <th>Giá</th>
                            <th>Số Lượng</th>
                            <th>Tổng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->items as $item)
                        <tr class="border-bottom">
                            <td>
                                <div class="d-flex gap-3 align-items-center">
                                    <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" 
                                         style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                    <div>
                                        <a href="{{ route('products.show', $item->product->slug) }}" class="text-decoration-none fw-bold">
                                            {{ $item->product->name }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>{{ number_format($item->product->getCurrentPrice()) }}đ</td>
                            <td>
                                <div class="input-group" style="width: 100px;">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-secondary" type="button" 
                                                onclick="this.form.quantity.value--; this.form.submit()">-</button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm text-center" readonly>
                                        <button class="btn btn-sm btn-outline-secondary" type="button" 
                                                onclick="this.form.quantity.value++; this.form.submit()">+</button>
                                    </form>
                                </div>
                            </td>
                            <td class="fw-bold">{{ number_format($item->getTotal()) }}đ</td>
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
                        <span class="fw-bold">{{ number_format($cart->getTotalPrice()) }}đ</span>
                    </div>

                    <div class="mb-4 pb-4 border-bottom">
                        <form id="couponForm" class="d-flex gap-2">
                            <input type="text" name="coupon_code" class="form-control form-control-sm" placeholder="Nhập mã khuyến mại">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="applyCoupon()">Áp Dụng</button>
                        </form>
                    </div>

                    <div class="d-flex justify-content-between mb-4 pb-3 border-bottom">
                        <span>Giảm Giá:</span>
                        <span class="fw-bold text-danger" id="discountAmount">0đ</span>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Tổng Cộng:</span>
                        <span class="h5 text-primary fw-bold" id="totalAmount">{{ number_format($cart->getTotalPrice()) }}đ</span>
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
            document.getElementById('discountAmount').textContent = response.data.discount.toLocaleString('vi-VN') + 'đ';
            document.getElementById('totalAmount').textContent = response.data.total.toLocaleString('vi-VN') + 'đ';
            alert('Áp dụng mã khuyến mại thành công');
        })
        .catch(error => {
            alert(error.response.data.error);
        });
}
</script>
@endsection