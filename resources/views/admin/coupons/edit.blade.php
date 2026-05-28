@extends('layouts.admin')

@section('title', 'Chỉnh sửa Mã giảm giá')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Mã giảm giá</a></li>
    <li class="breadcrumb-item active">Chỉnh sửa</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Chỉnh sửa Mã giảm giá</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Coupon Code (Read-only) -->
                        <div class="mb-3">
                            <label for="code" class="form-label fw-bold">Mã giảm giá</label>
                            <input type="text" class="form-control" id="code" value="{{ $coupon->code }}" readonly>
                            <small class="text-muted">Mã giảm giá không thể thay đổi</small>
                        </div>
                        
                        <!-- Coupon Type (Read-only) -->
                        <div class="mb-3">
                            <label for="type" class="form-label fw-bold">Loại giảm giá</label>
                            <select class="form-select" id="type" disabled>
                                <option selected>
                                    {{ $coupon->type == 'percentage' ? 'Phần trăm (%)' : 'Cố định (₫)' }}
                                </option>
                            </select>
                            <small class="text-muted">Loại giảm giá không thể thay đổi</small>
                        </div>
                        
                        <!-- Coupon Value (Read-only) -->
                        <div class="mb-3">
                            <label for="value" class="form-label fw-bold">Giá trị</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="value" 
                                       value="{{ $coupon->value }}{{ $coupon->type == 'percentage' ? '%' : '₫' }}" readonly>
                            </div>
                            <small class="text-muted">Giá trị không thể thay đổi</small>
                        </div>
                        
                        <!-- Max Uses -->
                        <div class="mb-3">
                            <label for="max_uses" class="form-label fw-bold">Số lượt sử dụng tối đa</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('max_uses') is-invalid @enderror" 
                                       id="max_uses" name="max_uses" value="{{ old('max_uses', $coupon->max_uses) }}" placeholder="Để trống = không giới hạn" min="1">
                                <span class="input-group-text">{{ $coupon->used_count ?? 0 }}/{{ $coupon->max_uses ?? '∞' }}</span>
                            </div>
                            <small class="text-muted">Để trống nếu không có giới hạn</small>
                            @error('max_uses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Start Date -->
                        <div class="mb-3">
                            <label for="start_date" class="form-label fw-bold">Ngày bắt đầu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" name="start_date" value="{{ old('start_date', $coupon->start_date) }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- End Date -->
                        <div class="mb-3">
                            <label for="end_date" class="form-label fw-bold">Ngày kết thúc <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" name="end_date" value="{{ old('end_date', $coupon->end_date) }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description (Optional) -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Mô tả (Tùy chọn)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" placeholder="Mô tả ngắn về mã giảm giá">{{ old('description', $coupon->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Cập nhật mã giảm giá
                            </button>
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Info Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-light mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle"></i> Thông tin</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><strong>Mã giảm:</strong><br>{{ $coupon->code }}</li>
                        <li class="mb-2"><strong>Loại:</strong><br>
                            {{ $coupon->type == 'percentage' ? 'Phần trăm (%)' : 'Cố định (₫)' }}
                        </li>
                        <li class="mb-2"><strong>Giá trị:</strong><br>
                            {{ $coupon->value }}{{ $coupon->type == 'percentage' ? '%' : '₫' }}
                        </li>
                        <li class="mb-2"><strong>Lượt sử dụng:</strong><br>
                            {{ $coupon->used_count ?? 0 }}/{{ $coupon->max_uses ?? 'Không giới hạn' }}
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Status Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-check-circle"></i> Trạng thái</h6>
                    @php
                        $now = \Carbon\Carbon::now();
                        $start = \Carbon\Carbon::parse($coupon->start_date);
                        $end = \Carbon\Carbon::parse($coupon->end_date);
                    @endphp
                    @if($now < $start)
                        <span class="badge bg-warning p-2" style="font-size: 0.9rem;">
                            <i class="bi bi-clock"></i> Sắp có
                        </span>
                    @elseif($now > $end)
                        <span class="badge bg-danger p-2" style="font-size: 0.9rem;">
                            <i class="bi bi-x-circle"></i> Hết hạn
                        </span>
                    @else
                        <span class="badge bg-success p-2" style="font-size: 0.9rem;">
                            <i class="bi bi-check-circle"></i> Hoạt động
                        </span>
                    @endif
                    <div class="mt-3">
                        <small class="text-muted">
                            <strong>Ngày bắt đầu:</strong> {{ \Carbon\Carbon::parse($coupon->start_date)->format('d/m/Y') }}<br>
                            <strong>Ngày kết thúc:</strong> {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
