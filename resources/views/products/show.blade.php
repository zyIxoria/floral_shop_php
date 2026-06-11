@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-5">
            <div class="card border-0">
                <div class="card-body p-0">
                    <img id="mainImage" src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded">
                </div>
            </div>
            @if($product->images->count() > 0)
            <div class="d-flex gap-2 mt-3">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                     class="img-thumbnail cursor-pointer" style="width: 80px; height: 80px; object-fit: cover;"
                     onclick="document.getElementById('mainImage').src = this.src">
                @foreach($product->images as $image)
                <img src="{{ $image->image_url }}" alt="{{ $product->name }}" 
                     class="img-thumbnail cursor-pointer" style="width: 80px; height: 80px; object-fit: cover;"
                     onclick="document.getElementById('mainImage').src = this.src">
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="col-lg-7">
            <h1 class="fw-bold mb-2">{{ $product->name }}</h1>

            <!-- Rating -->
            <div class="mb-3">
                @if($product->rating > 0)
                    <span class="text-warning">
                        @for($i = 0; $i < round($product->rating); $i++)
                            <i class="bi bi-star-fill"></i>
                        @endfor
                        ({{ $product->rating }} - {{ $product->review_count }} đánh giá)
                    </span>
                @else
                    <span class="text-muted">Chưa có đánh giá</span>
                @endif
            </div>

            <!-- Price -->
            <div class="mb-4">
                @if($product->isOnSale())
                    <span class="display-6 text-danger fw-bold price-amount" data-vnd="{{ $product->sale_price }}">{{ number_format($product->sale_price) }}đ</span>
                    <span class="text-muted text-decoration-line-through price-amount" data-vnd="{{ $product->price }}">{{ number_format($product->price) }}đ</span>
                    <span class="badge bg-danger">-{{ $product->getDiscount() }}%</span>
                @else
                    <span class="display-6 text-primary fw-bold price-amount" data-vnd="{{ $product->price }}">{{ number_format($product->price) }}đ</span>
                @endif
            </div>

            <!-- Stock -->
            <div class="mb-4">
                @if($product->isInStock())
                    <span class="badge bg-success">Còn {{ $product->stock }} sản phẩm</span>
                @else
                    <span class="badge bg-danger">Hết hàng</span>
                @endif
            </div>

            <!-- Description -->
            <div class="mb-4">
                <h6 class="fw-bold">Mô Tả</h6>
                <p class="text-muted">{{ $product->description }}</p>
            </div>

            <!-- Add to Cart -->
            <div class="mb-4">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="d-flex gap-2">
                        <div class="input-group flex-nowrap" style="width: 140px;">
                            <button class="btn btn-outline-secondary px-3" type="button" onclick="if(this.form.quantity.value > 1) this.form.quantity.value--">-</button>
                            <input type="text" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control text-center px-1" readonly>
                            <button class="btn btn-outline-secondary px-3" type="button" onclick="if(this.form.quantity.value < {{ $product->stock }}) this.form.quantity.value++">+</button>
                        </div>
                        <button type="submit" name="action" value="add" class="btn btn-primary flex-grow-1" {{ !$product->isInStock() ? 'disabled' : '' }}>
                            <i class="bi bi-bag-plus"></i> Thêm Vào Giỏ
                        </button>
                        <button type="submit" name="action" value="buy_now" class="btn btn-primary flex-grow-1" {{ !$product->isInStock() ? 'disabled' : '' }}>
                            <i class="bi bi-cart-check"></i> Thanh Toán Ngay
                        </button>
                    </div>
                </form>
            </div>

            <!-- Wishlist -->
            <div class="mb-4">
                @auth
                    <form action="{{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? route('wishlist.remove', $product->id) : route('wishlist.add') }}" 
                          method="POST" class="d-inline">
                        @csrf
                        @if(auth()->user()->wishlists()->where('product_id', $product->id)->exists())
                            @method('DELETE')
                        @else
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        @endif
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-heart{{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? '-fill' : '' }}"></i>
                            {{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'Xóa khỏi yêu thích' : 'Thêm vào yêu thích' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-danger">
                        <i class="bi bi-heart"></i> Thêm vào yêu thích
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-4">Đánh Giá Từ Khách Hàng</h4>

            @auth
                @php
                    $user = auth()->user();
                    $ordersOfProduct = \App\Models\Order::where('orders.user_id', $user->id)
                        ->where('orders.status', 'delivered')
                        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                        ->where('order_items.product_id', $product->id)
                        ->select('orders.id')
                        ->pluck('id');
                    
                    $reviewedOrderIds = \App\Models\Review::where('user_id', $user->id)
                        ->where('product_id', $product->id)
                        ->whereIn('order_id', $ordersOfProduct)
                        ->pluck('order_id');
                        
                    $isEligibleToReview = $ordersOfProduct->diff($reviewedOrderIds)->isNotEmpty();
                @endphp

                @if($isEligibleToReview)
                    <!-- Add Review Form -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Viết Đánh Giá</h6>
                            <form action="{{ route('reviews.store', $product) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Đánh Giá</label>
                                    <div>
                                        @for($i = 1; $i <= 5; $i++)
                                            <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $i }}">
                                            <label for="rating{{ $i }}" class="form-check-label">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bình Luận</label>
                                    <textarea name="comment" class="form-control" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Gửi Đánh Giá</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm mb-4 bg-light">
                        <div class="card-body text-center py-4">
                            <i class="bi bi-info-circle text-primary" style="font-size: 24px;"></i>
                            @if($ordersOfProduct->isEmpty())
                                <p class="text-muted mt-2 mb-0">Bạn chỉ được đánh giá sản phẩm sau khi đã mua sản phẩm này và đơn hàng được giao thành công.</p>
                            @else
                                <p class="text-muted mt-2 mb-0">Bạn đã hoàn thành đánh giá cho tất cả các lượt mua sản phẩm này. Hãy tiếp tục mua hàng để có thêm lượt đánh giá nhé!</p>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <div class="card border-0 shadow-sm mb-4 bg-light">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-person-lock text-muted" style="font-size: 24px;"></i>
                        <p class="text-muted mt-2 mb-0">Vui lòng <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Đăng nhập</a> để viết đánh giá cho sản phẩm.</p>
                    </div>
                </div>
            @endauth

            <!-- Reviews List -->
            @forelse($reviews as $review)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-bold">{{ $review->user->name }}</h6>
                            <div class="text-warning small mb-2">
                                @for($i = 0; $i < $review->rating; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                            </div>
                            <p class="text-muted">{{ $review->comment }}</p>
                        </div>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-info">Chưa có đánh giá nào</div>
            @endforelse
        </div>

        <!-- Related Products -->
        <div class="col-lg-4">
            <h5 class="fw-bold mb-4">Sản Phẩm Liên Quan</h5>
            @foreach($relatedProducts as $related)
            <div class="card border-0 shadow-sm mb-3">
                <div style="height: 150px; overflow: hidden;">
                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="card-img-top h-100 object-fit-cover">
                </div>
                <div class="card-body p-3">
                    <a href="{{ route('products.show', $related->slug) }}" class="text-decoration-none">
                        <h6 class="fw-bold card-title small">{{ Str::limit($related->name, 20) }}</h6>
                    </a>
                    <p class="text-primary fw-bold small price-amount" data-vnd="{{ $related->getCurrentPrice() }}">{{ number_format($related->getCurrentPrice()) }}đ</p>
                    <form action="{{ route('cart.add') }}" method="POST" class="d-grid">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $related->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-sm btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection