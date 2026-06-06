@extends('layouts.admin')

@section('title', 'Thêm Mã giảm giá')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Mã giảm giá</a></li>
    <li class="breadcrumb-item active">Thêm mới</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Tạo Mã giảm giá mới</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf
                        
                        <!-- Coupon Code -->
                        <div class="mb-3">
                            <label for="code" class="form-label fw-bold">Mã giảm giá <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                   id="code" name="code" value="{{ old('code') }}" placeholder="VD: SUMMER2024" 
                                   style="text-transform: uppercase;">
                            <small class="text-muted">Mã phải là chữ hoa, không có khoảng trắng</small>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Coupon Type -->
                        <div class="mb-3">
                            <label for="discount_type" class="form-label fw-bold">Loại giảm giá <span class="text-danger">*</span></label>
                            <select class="form-select @error('discount_type') is-invalid @enderror" id="discount_type" name="discount_type" onchange="updateValueLabel()">
                                <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Cố định (₫)</option>
                            </select>
                            @error('discount_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Coupon Value -->
                        <div class="mb-3">
                            <label for="discount_value" class="form-label fw-bold">Giá trị <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('discount_value') is-invalid @enderror" 
                                       id="discount_value" name="discount_value" value="{{ old('discount_value') }}" placeholder="0" step="1">
                                <span class="input-group-text" id="valueUnit">%</span>
                            </div>
                            @error('discount_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Minimum Order Value -->
                        <div class="mb-3">
                            <label for="min_order_value" class="form-label fw-bold">Giá trị đơn hàng tối thiểu <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('min_order_value') is-invalid @enderror" 
                                       id="min_order_value" name="min_order_value" value="{{ old('min_order_value', 0) }}" placeholder="0" min="0">
                                <span class="input-group-text">₫</span>
                            </div>
                            @error('min_order_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Max Uses -->
                        <div class="mb-3">
                            <label for="usage_limit" class="form-label fw-bold">Số lượt sử dụng tối đa</label>
                            <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" 
                                   id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}" placeholder="Để trống = không giới hạn" min="1">
                            <small class="text-muted">Để trống nếu không có giới hạn</small>
                            @error('usage_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Start Date -->
                        <div class="mb-3">
                            <label for="start_date" class="form-label fw-bold">Ngày bắt đầu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" name="start_date" value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- End Date -->
                        <div class="mb-3">
                            <label for="end_date" class="form-label fw-bold">Ngày kết thúc <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" name="end_date" value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description (Optional) -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Mô tả (Tùy chọn)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" placeholder="Mô tả ngắn về mã giảm giá">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Tạo mã giảm giá
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
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle"></i> Hướng dẫn</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">✓ Mã giảm giá phải là duy nhất</li>
                        <li class="mb-2">✓ Chọn loại giảm giá: phần trăm hoặc cố định</li>
                        <li class="mb-2">✓ Đặt ngày bắt đầu và kết thúc</li>
                        <li class="mb-2">✓ Giới hạn số lần sử dụng (tùy chọn)</li>
                        <li class="mb-2">✓ Ngày kết thúc phải sau ngày bắt đầu</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateValueLabel() {
        const type = document.getElementById('discount_type').value;
        const unit = document.getElementById('valueUnit');
        unit.textContent = type === 'percent' ? '%' : '₫';
    }
</script>
@endpush
@endsection
