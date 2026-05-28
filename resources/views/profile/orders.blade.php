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
                    <td class="fw-bold">{{ number_format($order->total) }}đ</td>
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
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                            Chi Tiết
                        </button>
                    </td>
                </tr>

                <!-- Order Detail Modal -->
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
                                <p><strong>Trạng Thái:</strong> {{ $order->status }}</p>

                                <h6 class="fw-bold mt-3">Sản Phẩm:</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <th>Sản Phẩm</th>
                                        <th>Số Lượng</th>
                                        <th>Giá</th>
                                        <th>Tổng</th>
                                    </tr>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price) }}đ</td>
                                        <td>{{ number_format($item->getTotal()) }}đ</td>
                                    </tr>
                                    @endforeach
                                </table>

                                <div class="text-end">
                                    <p><strong>Tổng Cộng:</strong> {{ number_format($order->total) }}đ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $orders->links() }}
    @else
    <div class="alert alert-info">
        Bạn chưa có đơn hàng nào. <a href="{{ route('shop') }}">Mua sắm ngay</a>
    </div>
    @endif
</div>
@endsection