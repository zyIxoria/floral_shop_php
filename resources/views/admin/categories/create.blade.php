@extends('layouts.admin')

@section('title', 'Thêm Danh mục')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh mục</a></li>
    <li class="breadcrumb-item active">Thêm mới</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Tạo Danh mục mới</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Category Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" placeholder="Nhập tên danh mục">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Mô tả <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" placeholder="Mô tả chi tiết danh mục">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Category Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">Hình ảnh danh mục <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                            </div>
                            <small class="text-muted">Định dạng: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Tạo danh mục
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
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
                        <li class="mb-2">✓ Tên danh mục phải rõ ràng, dễ hiểu</li>
                        <li class="mb-2">✓ Mô tả giúp khách hàng hiểu rõ loại hoa</li>
                        <li class="mb-2">✓ Hình ảnh nên có chất lượng cao</li>
                        <li class="mb-2">✓ Slug sẽ tự động tạo từ tên danh mục</li>
                        <li class="mb-2">✓ Hình ảnh tốt sẽ tăng tính hấp dẫn</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
