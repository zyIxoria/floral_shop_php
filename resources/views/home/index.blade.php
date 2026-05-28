@extends('layouts.app')

@section('title', 'Trang Chủ')

@section('content')
<!-- Hero Banner -->
<div class="hero-banner position-relative overflow-hidden" style="background: linear-gradient(135deg, #fff5f9 0%, #f0f8f4 100%); padding: 80px 0;">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold text-primary mb-3">
                    Hoa Tươi Đẹp Nhất Cho Bạn
                </h1>
                <p class="lead text-muted mb-4">
                    Chúng tôi cung cấp những bó hoa tươi đẹp, tuyệt vời cho mọi dịp. 
                    Giao hàng nhanh chóng, an toàn.
                </p>
                <a href="{{ route('shop') }}" class="btn btn-primary btn-lg">
                    Mua Ngay <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <img src="https://via.placeholder.com/400x400?text=Flowers" alt="Hero" class="img-fluid rounded-4 shadow">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories -->
<section class="py-5">
    <div class="container-fluid px-4">
        <h2 class="fw-bold text-center mb-5">Danh Mục Sản Phẩm</h2>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('shop.category', $category->slug) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-img-top bg-light" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                            @if($category->image)
                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="img-fluid" style="max-height: 100%; object-fit: cover;">
                            @else
                                <i class="bi bi-flower1" style="font-size: 3rem; color: #ffc0e3;"></i>
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold text-dark">{{ $category->name }}</h5>
                            <p class="text-muted small">{{ $category->products_count }} Sản Phẩm</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <h2 class="fw-bold text-center mb-5">Sản Phẩm Nổi Bật</h2>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-md-6 col-lg-3">
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
                            <h5 class="card-title text-dark fw-bold">{{ $product->name }}</h5>
                        </a>
                        <div class="mb-2">
                            @if($product->isOnSale())
                                <span class="h5 text-danger fw-bold">{{ number_format($product->sale_price) }}đ</span>
                                <span class="text-muted text-decoration-line-through small">{{ number_format($product->price) }}đ</span>
                            @else
                                <span class="h5 text-primary fw-bold">{{ number_format($product->price) }}đ</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($product->rating > 0)
                                    <span class="text-warning">
                                        <i class="bi bi-star-fill"></i> {{ $product->rating }}
                                    </span>
                                @endif
                            </div>
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-bag-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Sale Products -->
<section class="py-5">
    <div class="container-fluid px-4">
        <h2 class="fw-bold text-center mb-5">Khuyến Mại Hot</h2>
        <div class="row g-4">
            @foreach($saleProducts as $product)
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 product-card">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="card-img-top h-100 object-fit-cover">
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                            -{{ $product->getDiscount() }}%
                        </span>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                            <h5 class="card-title text-dark fw-bold">{{ $product->name }}</h5>
                        </a>
                        <div class="mb-2">
                            <span class="h5 text-danger fw-bold">{{ number_format($product->sale_price) }}đ</span>
                            <span class="text-muted text-decoration-line-through small">{{ number_format($product->price) }}đ</span>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100 btn-sm">
                                <i class="bi bi-bag-plus"></i> Thêm Vào Giỏ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 bg-light">
    <div class="container-fluid px-4">
        <h2 class="fw-bold text-center mb-5">Đánh Giá Từ Khách Hàng</h2>
        <div class="row g-4">
            @foreach($reviews as $review)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            @for($i = 0; $i < $review->rating; $i++)
                                <i class="bi bi-star-fill text-warning"></i>
                            @endfor
                            @for($i = $review->rating; $i < 5; $i++)
                                <i class="bi bi-star text-warning"></i>
                            @endfor
                        </div>
                        <p class="card-text text-muted">{{ $review->comment }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-subtitle fw-bold">{{ $review->user->name }}</h6>
                            <small class="text-muted">{{ $review->product->name }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection