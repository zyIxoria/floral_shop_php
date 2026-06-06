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
            @include('components.product-card', ['product' => $product])
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