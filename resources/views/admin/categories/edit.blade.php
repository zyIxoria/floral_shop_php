@extends('layouts.admin')

@section('title', 'Chỉnh sửa Danh mục')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh mục</a></li>
    <li class="breadcrumb-item active">Chỉnh sửa</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Chỉnh sửa Danh mục</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Category Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $category->name) }}" placeholder="Nhập tên danh mục">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Mô tả <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" placeholder="Mô tả chi tiết danh mục">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Slug (Read-only) -->
                        <div class="mb-3">
                            <label for="slug" class="form-label fw-bold">Slug</label>
                            <input type="text" class="form-control" id="slug" value="{{ $category->slug }}" readonly>
                            <small class="text-muted">Slug được tạo tự động và không thể thay đổi</small>
                        </div>
                        
                        <!-- Category Image -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Hình ảnh danh mục</label>
                            @if($category->image)
                                <div class="mb-3">
                                    <p class="text-muted small mb-1">Hình ảnh hiện tại:</p>
                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                                         style="max-width: 200px; height: auto; border-radius: 8px;" class="border p-1 bg-white shadow-sm">
                                </div>
                            @endif
                            
                            <ul class="nav nav-tabs mb-2" id="imageTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active py-1 px-3" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-pane" type="button" role="tab" style="font-size: 0.85rem;">Tải lên file</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-1 px-3" id="url-tab" data-bs-toggle="tab" data-bs-target="#url-pane" type="button" role="tab" style="font-size: 0.85rem;">Nhập link ảnh online</button>
                                </li>
                            </ul>
                            <div class="tab-content border p-3 rounded bg-light" id="imageTabContent">
                                <div class="tab-pane fade show active" id="upload-pane" role="tabpanel">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                    <small class="text-muted d-block mt-1">Định dạng: JPEG, PNG, JPG, GIF (Max: 2MB) - Bỏ trống nếu không muốn thay đổi</small>
                                </div>
                                <div class="tab-pane fade" id="url-pane" role="tabpanel">
                                    <input type="url" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" placeholder="https://example.com/image.jpg" value="{{ old('image_url', Str::startsWith($category->image, ['http://', 'https://']) ? $category->image : '') }}">
                                    <small class="text-muted d-block mt-1">Nhập đường dẫn trực tiếp của hình ảnh (phải bắt đầu bằng http:// hoặc https://)</small>
                                </div>
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                            @error('image_url')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Cập nhật danh mục
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
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle"></i> Thông tin</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><strong>Ngày tạo:</strong><br>{{ $category->created_at->format('d/m/Y H:i') }}</li>
                        <li class="mb-2"><strong>Lần cập nhật:</strong><br>{{ $category->updated_at->format('d/m/Y H:i') }}</li>
                        <li class="mb-2"><strong>Tổng sản phẩm:</strong><br>{{ $category->products_count ?? 0 }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
