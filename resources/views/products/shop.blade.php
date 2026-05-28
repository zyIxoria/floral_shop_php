@extends('layouts.app')

@section('title', 'Cửa Hàng')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <h5 class="fw-bold mb-4">Bộ Lọc</h5>

            <!-- Categories Filter -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3">Danh Mục</h6>
                <div class="list-group">
                    <a href="{{ route('shop') }}" class="list-group-item list-group-item-action {{ !$category ? 'active' : '' }}">
                        Tất Cả
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('shop.category', $cat->slug) }}" 
                           class="list-group-item list-group-item-action {{ $category === $cat->slug ? 'active' : '' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Sort -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3">Sắp Xếp</h6>
                <select class="form-select form-select-sm" onchange="window.location.href = new URL(window.location).searchParams.set('sort', this.value) || '{{ route('shop') }}'; window.location.href = window.location;">
                    <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Mới Nhất</option>
                    <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Giá Thấp Nhất</option>
                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Giá Cao Nhất</option>
                </select>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Search Bar -->
            <div class="mb-4">
                <form action="{{ route('shop') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ $search }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <!-- Products -->
            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 product-card">
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="card-img-top h-100 object-fit-cover">
                            @if($product->isOnSale())
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                -{{ $product->getDiscount() }}%
                            </span>
                            @endif
                        </div>
                        <div class="card-body">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                                <h5 class="card-title text-dark fw-bold small">{{ Str::limit($product->name, 30) }}</h5>
                            </a>
                            <div class="mb-2">
                                @if($product->isOnSale())
                                    <span class="h6 text-danger fw-bold">{{ number_format($product->sale_price) }}đ</span>
                                    <span class="text-muted text-decoration-line-through small">{{ number_format($product->price) }}đ</span>
                                @else
                                    <span class="h6 text-primary fw-bold">{{ number_format($product->price) }}đ</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                @if($product->isInStock())
                                    <small class="text-success">Còn hàng</small>
                                @else
                                    <small class="text-danger">Hết hàng</small>
                                @endif
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Không tìm thấy sản phẩm nào.
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection