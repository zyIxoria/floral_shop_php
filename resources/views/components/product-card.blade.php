{{-- resources/views/components/product-card.blade.php --}}
<div class="card border-0 shadow-sm h-100 product-card">
    <div class="position-relative overflow-hidden" style="height: 250px;">
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="card-img-top h-100 object-fit-cover">
        </a>
        @if($product->isOnSale())
        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
            -{{ $product->getDiscount() }}%
        </span>
        @endif
        @if(!$product->isInStock())
        <span class="badge bg-secondary position-absolute top-0 start-0 m-2">
            Hết hàng
        </span>
        @endif
    </div>
    <div class="card-body d-flex flex-column">
        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none mb-2">
            <h5 class="card-title text-dark fw-bold" style="font-size: 1rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8em;">
                {{ $product->name }}
            </h5>
        </a>
        
        <div class="mb-3 mt-auto">
            @if($product->isOnSale())
                <span class="h6 text-danger fw-bold mb-0 price-amount" data-vnd="{{ $product->sale_price }}">{{ number_format($product->sale_price) }}đ</span>
                <span class="text-muted text-decoration-line-through small d-block price-amount" data-vnd="{{ $product->price }}">{{ number_format($product->price) }}đ</span>
            @else
                <span class="h6 text-primary fw-bold mb-0 price-amount" data-vnd="{{ $product->price }}">{{ number_format($product->price) }}đ</span>
                <span class="small d-block" style="visibility: hidden;">Placeholder</span>
            @endif
        </div>

        <div class="d-flex gap-2">
            <form action="{{ route('cart.add') }}" method="POST" class="flex-grow-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-primary w-100 btn-sm" {{ !$product->isInStock() ? 'disabled' : '' }}>
                    <i class="bi bi-bag-plus"></i> <span class="d-none d-sm-inline">Thêm</span>
                </button>
            </form>
            @auth
                @if(request()->routeIs('profile.wishlist') || request()->routeIs('wishlist.index'))
                    <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Xóa khỏi yêu thích">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                @else
                    <form action="{{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? route('wishlist.remove', $product->id) : route('wishlist.add') }}" method="POST">
                        @csrf
                        @if(auth()->user()->wishlists()->where('product_id', $product->id)->exists())
                            @method('DELETE')
                        @else
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        @endif
                        <button type="submit" class="btn btn-{{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'danger' : 'outline-danger' }} btn-sm" title="Yêu thích">
                            <i class="bi bi-heart{{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? '-fill' : '' }}"></i>
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm" title="Đăng nhập để yêu thích">
                    <i class="bi bi-heart"></i>
                </a>
            @endauth
        </div>
    </div>
</div>