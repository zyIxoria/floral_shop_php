@extends('layouts.admin')

@section('title', 'Quản lý Mã giảm giá')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Mã giảm giá</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Quản lý Mã giảm giá</h3>
            <p class="text-muted">Tổng cộng: <strong>{{ $coupons->total() }}</strong> mã giảm giá</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Thêm mã giảm giá
        </a>
    </div>
    
    <!-- Coupons Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($coupons->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã giảm</th>
                                <th>Loại</th>
                                <th>Giá trị</th>
                                <th>Lượt sử dụng</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $coupon)
                                <tr>
                                    <td>
                                        <strong>{{ $coupon->code }}</strong>
                                    </td>
                                    <td>
                                        @if($coupon->type == 'percentage')
                                            <span class="badge bg-primary">Phần trăm</span>
                                        @else
                                            <span class="badge bg-info">Cố định</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($coupon->type == 'percentage')
                                            <strong>{{ $coupon->value }}%</strong>
                                        @else
                                            <strong>{{ number_format($coupon->value, 0, ',', '.') }} ₫</strong>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $coupon->used_count ?? 0 }}/{{ $coupon->max_uses ?? 'Không giới hạn' }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($coupon->start_date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @php
                                            $now = \Carbon\Carbon::now();
                                            $start = \Carbon\Carbon::parse($coupon->start_date);
                                            $end = \Carbon\Carbon::parse($coupon->end_date);
                                        @endphp
                                        @if($now < $start)
                                            <span class="badge bg-warning"><i class="bi bi-clock"></i> Sắp có</span>
                                        @elseif($now > $end)
                                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Hết hạn</span>
                                        @else
                                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Hoạt động</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $coupon->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $coupon->id }}" action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                    <p class="text-muted mt-3">Chưa có mã giảm giá nào</p>
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-lg"></i> Tạo mã giảm giá đầu tiên
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Pagination -->
    @if($coupons->count() > 0)
        <div class="d-flex justify-content-center mt-4">
            {{ $coupons->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        if(confirm('Bạn chắc chắn muốn xóa mã giảm giá này?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection
