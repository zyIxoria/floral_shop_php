@extends('layouts.admin')

@section('title', 'Thêm Sản phẩm')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
    <li class="breadcrumb-item active">Thêm mới</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold text-white" style="color: white !important;">Tạo Sản phẩm mới</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" placeholder="Nhập tên sản phẩm">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Mô tả <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" placeholder="Mô tả chi tiết sản phẩm">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Main Image -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Hình ảnh chính <span class="text-danger">*</span></label>
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
                                    <small class="text-muted d-block mt-1">Định dạng: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                                </div>
                                <div class="tab-pane fade" id="url-pane" role="tabpanel">
                                    <input type="url" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" placeholder="https://example.com/image.jpg" value="{{ old('image_url') }}">
                                    <small class="text-muted d-block mt-1">Nhập đường dẫn trực tiếp của hình ảnh (bắt đầu bằng http:// hoặc https://)</small>
                                </div>
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                            @error('image_url')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description Images (Gallery) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Hình ảnh mô tả (Tối thiểu 3 hình ảnh) <span class="text-danger">*</span></label>
                            <ul class="nav nav-tabs mb-2" id="galleryTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active py-1 px-3" id="gallery-upload-tab" data-bs-toggle="tab" data-bs-target="#gallery-upload-pane" type="button" role="tab" style="font-size: 0.85rem;">Tải lên file</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-1 px-3" id="gallery-url-tab" data-bs-toggle="tab" data-bs-target="#gallery-url-pane" type="button" role="tab" style="font-size: 0.85rem;">Nhập link ảnh online</button>
                                </li>
                            </ul>
                            <div class="tab-content border p-3 rounded bg-light" id="galleryTabContent">
                                <div class="tab-pane fade show active" id="gallery-upload-pane" role="tabpanel">
                                    <input type="file" class="form-control @error('description_images') is-invalid @enderror @error('description_images.*') is-invalid @enderror" id="description_images" name="description_images[]" accept="image/*" multiple>
                                    <small class="text-muted d-block mt-1">Định dạng: JPEG, PNG, JPG, GIF (Max: 2MB/ảnh). Vui lòng chọn ít nhất 3 hình ảnh.</small>
                                </div>
                                <div class="tab-pane fade" id="gallery-url-pane" role="tabpanel">
                                    <textarea class="form-control @error('description_images_urls') is-invalid @enderror" id="description_images_urls" name="description_images_urls" rows="4" placeholder="Nhập mỗi link ảnh trên một dòng, tối thiểu 3 link. Ví dụ:&#10;https://example.com/image1.jpg&#10;https://example.com/image2.jpg&#10;https://example.com/image3.jpg">{{ old('description_images_urls') }}</textarea>
                                    <small class="text-muted d-block mt-1">Mỗi dòng là một đường dẫn hình ảnh trực tiếp.</small>
                                </div>
                            </div>
                            @error('description_images')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                            @error('description_images_urls')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                            @error('description_images.*')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Price -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold">Giá gốc <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price') }}" placeholder="0" step="1000">
                                    <span class="input-group-text">₫</span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Sale Price -->
                            <div class="col-md-6 mb-3">
                                <label for="sale_price" class="form-label fw-bold">Giá bán (Tùy chọn)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('sale_price') is-invalid @enderror" 
                                           id="sale_price" name="sale_price" value="{{ old('sale_price') }}" placeholder="0" step="1000">
                                    <span class="input-group-text">₫</span>
                                </div>
                                <small class="text-muted">Để trống nếu không có khuyến mãi</small>
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Stock -->
                        <div class="mb-3">
                            <label for="stock" class="form-label fw-bold">Số lượng tồn kho <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock') }}" placeholder="0" min="0">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Tạo sản phẩm
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
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
                        <li class="mb-2">✓ Tên sản phẩm phải rõ ràng, dễ hiểu</li>
                        <li class="mb-2">✓ Mô tả chi tiết giúp khách hiểu rõ hơn</li>
                        <li class="mb-2">✓ Hình ảnh nên có chất lượng cao</li>
                        <li class="mb-2">✓ Giá bán nên dưới giá gốc để có khuyến mãi</li>
                        <li class="mb-2">✓ Đầy đủ thông tin sẽ giúp sản phẩm bán tốt hơn</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
