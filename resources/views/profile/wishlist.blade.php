@extends('layouts.app')

@section('title', 'Yêu Thích')

@section('content')
<div class="container-fluid px-4 py-5">
    <h2 class="fw-bold mb-4">Sản Phẩm Yêu Thích</h2>

    @if($wishlists->count() > 0)
    <div class="row g-4">
        @foreach($wishlists as $wishlist)
        <div class="col-md-6 col-lg-3">
            @php $product = $wishlist->product; @endphp
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
                    <div class="mb-3">
                        @if($product->isOnSale())
                            <span class="h6 text-danger fw-bold">{{ number_format($product->sale_price) }}đ</span>
                            <span class="text-muted text-decoration-line-through small">{{ number_format($product->price) }}đ</span>
                        @else
                            <span class="h6 text-primary fw-bold">{{ number_format($product->price) }}đ</span>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        <form action="{{ route('cart.add') }}" method="POST" class="flex-grow-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100 btn-sm">
                                <i class="bi bi-bag-plus"></i>
                            </button>
                        </form>
                        <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $wishlists->links() }}
    @else
    <div class="alert alert-info">
        Bạn chưa thêm sản phẩm yêu thích nào. <a href="{{ route('shop') }}">Khám phá ngay</a>
    </div>
    @endif
</div>
@endsection