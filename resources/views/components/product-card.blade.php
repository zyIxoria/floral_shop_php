{{-- resources/views/components/product-card.blade.php --}}

<div class="card border-0 shadow-sm h-100">

    <div style="height:250px; overflow:hidden;">

        <img src="{{ Storage::url($product->image) }}"
             class="card-img-top h-100 object-fit-cover">

    </div>

    <div class="card-body">

        <a href="{{ route('products.show', $product->slug) }}"
           class="text-decoration-none text-dark">

            <h5 class="fw-bold">
                {{ $product->name }}
            </h5>

        </a>

        <p class="text-primary fw-bold">
            {{ number_format($product->getCurrentPrice()) }}đ
        </p>

        <form action="{{ route('cart.add') }}"
              method="POST">

            @csrf

            <input type="hidden"
                   name="product_id"
                   value="{{ $product->id }}">

            <button class="btn btn-primary w-100">
                Thêm Vào Giỏ
            </button>

        </form>

    </div>

</div>