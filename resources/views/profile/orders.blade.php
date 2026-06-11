@extends('layouts.app')

@section('title', 'Lịch Sử Đơn Hàng')

@section('content')
<div class="container-fluid px-4 py-5">
    <h2 class="fw-bold mb-4">Lịch Sử Đơn Hàng</h2>

    @if($orders->count() > 0)
    <div class="table-responsive">
        <table class="table border-0">
            <thead class="border-bottom bg-light">
                <tr>
                    <th>Mã Đơn</th>
                    <th>Ngày</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border-bottom">
                    <td class="fw-bold">{{ $order->order_number }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td class="fw-bold"><span class="price-amount" data-vnd="{{ $order->total }}">{{ number_format($order->total) }}đ</span></td>
                    <td>
                        <span class="badge 
                            {{ match($order->status) {
                                'pending' => 'bg-warning',
                                'confirmed' => 'bg-info',
                                'shipped' => 'bg-primary',
                                'delivered' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                default => 'bg-secondary'
                            } }}">
                            {{ match($order->status) {
                                'pending' => 'Chờ Xác Nhận',
                                'confirmed' => 'Đã Xác Nhận',
                                'shipped' => 'Đang Giao',
                                'delivered' => 'Đã Giao',
                                'cancelled' => 'Đã Hủy',
                                default => 'Không Xác Định'
                            } }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                Chi Tiết
                            </button>
                            @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                            <form action="{{ route('profile.order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Hủy Đơn
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Order Detail Modals (Placed outside the table to prevent HTML layout breaking) -->
    @foreach($orders as $order)
    <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $order->order_number }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Ngày:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Địa Chỉ:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Trạng Thái:</strong> 
                        <span class="badge 
                            {{ match($order->status) {
                                'pending' => 'bg-warning',
                                'confirmed' => 'bg-info',
                                'shipped' => 'bg-primary',
                                'delivered' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                default => 'bg-secondary'
                            } }}">
                            {{ match($order->status) {
                                'pending' => 'Chờ Xác Nhận',
                                'confirmed' => 'Đã Xác Nhận',
                                'shipped' => 'Đang Giao',
                                'delivered' => 'Đã Giao',
                                'cancelled' => 'Đã Hủy',
                                default => 'Không Xác Định'
                            } }}
                        </span>
                    </p>

                    @if($order->payment_method === 'bank_transfer' && $order->status === 'pending')
                    <div class="alert alert-warning border border-warning bg-warning bg-opacity-10 mt-3 p-3 text-start">
                        <h6 class="fw-bold text-warning-dark mb-2" style="color: #664d03;"><i class="bi bi-wallet2"></i> Thông Tin Chuyển Khoản</h6>
                        @php
                            $transferDescription = 'FLORAL' . auth()->id() . 'ORD' . $order->id;
                            $qrUrl = "https://img.vietqr.io/image/970422-225515233865-compact.png?amount=" . round($order->total) . "&addInfo=" . urlencode($transferDescription) . "&accountName=" . urlencode("FLORAL SHOP");
                        @endphp
                        <div class="row g-2 align-items-center">
                            <div class="col-sm-4 text-center">
                                <img src="{{ $qrUrl }}" alt="QR VietQR" class="img-fluid rounded border bg-white p-1" style="max-height: 120px;">
                            </div>
                            <div class="col-sm-8" style="font-size: 0.85rem;">
                                <div><strong>MB Bank (Ngân hàng Quân đội)</strong></div>
                                <div>Số tài khoản: <strong class="text-primary">225515233865</strong></div>
                                <div>Số tiền: <strong class="text-danger">{{ number_format($order->total, 0, ',', '.') }} ₫</strong></div>
                                <div>Nội dung: <strong class="text-danger">{{ $transferDescription }}</strong></div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <h6 class="fw-bold mt-4">Sản Phẩm:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Sản Phẩm</th>
                                    <th>Số Lượng</th>
                                    <th>Giá</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td><span class="price-amount" data-vnd="{{ $item->price }}">{{ number_format($item->price) }}đ</span></td>
                                    <td><span class="price-amount" data-vnd="{{ $item->getTotal() }}">{{ number_format($item->getTotal()) }}đ</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-3 border-top pt-2">
                        <p class="fs-5"><strong>Tổng Cộng:</strong> <span class="price-amount fw-bold text-primary" data-vnd="{{ $order->total }}">{{ number_format($order->total) }}đ</span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                    <form action="{{ route('profile.order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
                        @csrf
                        <button type="submit" class="btn btn-danger">Hủy Đơn Hàng</button>
                    </form>
                    @endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{ $orders->links() }}
    @else
    <div class="alert alert-info">
        Bạn chưa có đơn hàng nào. <a href="{{ route('shop') }}">Mua sắm ngay</a>
    </div>
    @endif
</div>
@endsection