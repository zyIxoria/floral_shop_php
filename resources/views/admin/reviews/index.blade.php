@extends('layouts.admin')

@section('title', 'Quản lý Đánh giá')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Đánh giá</li>
@endsection

@section('content')
<div class="container-fluid px-0">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Quản lý Đánh giá</h3>
            <p class="text-muted mb-0">Xem và lọc tất cả các đánh giá mà khách hàng đã gửi sau khi nhận hàng.</p>
        </div>
    </div>

    <!-- Stats & Filters Row -->
    <div class="row g-4 mb-4">
        <!-- Total Reviews Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 position-relative" style="background: linear-gradient(135deg, #ffffff 0%, #fffbfd 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Tổng lượt đánh giá</span>
                            <h3 class="fw-bold mt-2 mb-0 text-dark">{{ $totalReviews }} lượt</h3>
                        </div>
                        <div class="rounded-4 p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%); width: 56px; height: 56px;">
                            <i class="bi bi-chat-left-quote" style="font-size: 24px; color: #d97e9e !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Rating Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 position-relative" style="background: linear-gradient(135deg, #ffffff 0%, #fffbf8 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Điểm trung bình</span>
                            <h3 class="fw-bold mt-2 mb-0 text-dark">
                                {{ $averageRating }} / 5.0
                            </h3>
                            <div class="text-warning small mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <i class="bi bi-star-fill"></i>
                                    @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                        <i class="bi bi-star-half"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="rounded-4 p-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); width: 56px; height: 56px;">
                            <i class="bi bi-star-fill text-warning" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-funnel"></i> Bộ lọc tìm kiếm</h6>
                    <form action="{{ route('admin.reviews.index') }}" method="GET" class="row g-2">
                        <div class="col-md-6">
                            <select class="form-select" name="product_id" onchange="this.form.submit()">
                                <option value="">Tất cả sản phẩm</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" {{ $productId == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" name="rating" onchange="this.form.submit()">
                                <option value="">Tất cả số sao</option>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ $ratingFilter == $i ? 'selected' : '' }}>
                                        {{ $i }} sao
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            @if($productId || $ratingFilter)
                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary w-100">Xóa lọc</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3 px-4">
            <h5 class="mb-0 fw-bold text-white" style="color: white !important;">Danh sách Đánh giá</h5>
        </div>
        <div class="card-body p-0">
            @if($reviews->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted uppercase" style="font-size: 0.85rem;">
                            <tr>
                                <th class="py-3 px-4">Khách hàng</th>
                                <th class="py-3">Sản phẩm</th>
                                <th class="py-3 text-center">Đánh giá</th>
                                <th class="py-3">Nội dung</th>
                                <th class="py-3 text-center">Đơn hàng</th>
                                <th class="py-3">Ngày tạo</th>
                                <th class="py-3 text-center px-4">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                                <tr>
                                    <td class="py-3 px-4">
                                        <strong>{{ $review->user->name ?? 'N/A' }}</strong>
                                        <div class="text-muted small">{{ $review->user->email ?? '' }}</div>
                                    </td>
                                    <td class="py-3" style="max-width: 200px;">
                                        @if($review->product)
                                            <a href="{{ route('products.show', $review->product->slug) }}" target="_blank" class="text-decoration-none fw-bold text-primary">
                                                {{ $review->product->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">Đã xóa</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="text-warning">
                                            @for($i = 0; $i < $review->rating; $i++)
                                                <i class="bi bi-star-fill"></i>
                                            @endfor
                                            @for($i = $review->rating; $i < 5; $i++)
                                                <i class="bi bi-star text-muted"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="py-3 text-muted" style="max-width: 250px; white-space: normal;">
                                        {{ $review->comment }}
                                    </td>
                                    <td class="py-3 text-center">
                                        @if($review->order_id)
                                            <a href="{{ route('admin.orders.show', $review->order_id) }}" class="badge bg-secondary text-decoration-none">
                                                #{{ $review->order_id }}
                                            </a>
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-muted" style="font-size: 0.9rem;">
                                        {{ $review->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-3 text-center px-4">
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $review->id }})">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                        <form id="delete-form-{{ $review->id }}" action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display:none;">
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
                    <i class="bi bi-chat-left-text" style="font-size: 48px; color: #ccc;"></i>
                    <p class="text-muted mt-3">Không tìm thấy đánh giá nào</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($reviews->count() > 0)
        <div class="d-flex justify-content-center mt-4">
            {{ $reviews->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        if (confirm('Bạn chắc chắn muốn xóa đánh giá này? Việc này có thể ảnh hưởng đến điểm đánh giá trung bình của sản phẩm.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
