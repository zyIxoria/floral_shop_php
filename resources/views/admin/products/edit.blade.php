@extends('layouts.admin')

@section('title', 'Chỉnh sửa Sản phẩm')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
    <li class="breadcrumb-item active">Chỉnh sửa</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold text-white" style="color: white !important;">Chỉnh sửa: {{ $product->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="Nhập tên sản phẩm">
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
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                      id="description" name="description" rows="4" placeholder="Mô tả chi tiết sản phẩm">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Main Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">Hình ảnh chính</label>
                            
                            @if($product->image)
                                <div class="mb-3">
                                    <p class="text-muted small">Hình ảnh hiện tại:</p>
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                         style="max-width: 200px; border-radius: 8px;">
                                </div>
                            @endif
                            
                            <div class="input-group">
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                            </div>
                            <small class="text-muted">Định dạng: JPEG, PNG, JPG, GIF (Max: 2MB) - Bỏ trống nếu không muốn thay đổi</small>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description Images (Gallery) -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Hình ảnh mô tả hiện tại</label>
                            @if($product->images->count() > 0)
                                <div class="row g-2 mb-3">
                                    @foreach($product->images as $img)
                                        <div class="col-6 col-md-3 text-center position-relative">
                                            <div class="border rounded p-1 bg-white h-100 d-flex flex-column justify-content-between">
                                                <img src="{{ Storage::url($img->image) }}" alt="Gallery Image" class="img-fluid rounded" style="height: 100px; object-fit: cover;">
                                                <div class="form-check mt-2 d-flex justify-content-center">
                                                    <input class="form-check-input me-1" type="checkbox" name="delete_images[]" value="{{ $img->id }}" id="del_img_{{ $img->id }}">
                                                    <label class="form-check-label small text-danger" for="del_img_{{ $img->id }}">
                                                        Xóa ảnh này
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning py-2 mb-3 small">Sản phẩm hiện chưa có hình ảnh mô tả nào. Bạn phải tải lên ít nhất 3 ảnh!</div>
                            @endif

                            <label for="description_images" class="form-label fw-bold">Thêm hình ảnh mô tả mới (Tối thiểu 3 hình ảnh mô tả tổng cộng)</label>
                            <div class="input-group">
                                <input type="file" class="form-control @error('description_images') is-invalid @enderror @error('description_images.*') is-invalid @enderror" 
                                       id="description_images" name="description_images[]" accept="image/*" multiple>
                            </div>
                            <small class="text-muted">Định dạng: JPEG, PNG, JPG, GIF (Max: 2MB/ảnh). Sản phẩm phải giữ lại ít nhất 3 hình ảnh mô tả.</small>
                            @error('description_images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('description_images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Price -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold">Giá gốc <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $product->price) }}" placeholder="0" step="1000">
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
                                           id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" placeholder="0" step="1000">
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
                                   id="stock" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="0" min="0">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Cập nhật
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
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle"></i> Thông tin sản phẩm</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><strong>Slug:</strong> {{ $product->slug }}</li>
                        <li class="mb-2"><strong>Tạo lúc:</strong> {{ $product->created_at->format('d/m/Y H:i') }}</li>
                        <li class="mb-2"><strong>Cập nhật lúc:</strong> {{ $product->updated_at->format('d/m/Y H:i') }}</li>
                        <li class="mb-2"><strong>Tổng số lượng bán:</strong> {{ \App\Models\OrderItem::where('product_id', $product->id)->sum('quantity') ?? 0 }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
