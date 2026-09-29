<div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card product-card h-100 position-relative">
        <div class="overflow-hidden" style="height:220px">
            <img src="{{ $product->image_url }}" class="product-card__img w-100 h-100" alt="{{ $product->name }}" loading="lazy">
        </div>
        @if($product->is_featured)
            <span class="product-card__badge bg-warning text-dark">⭐ Featured</span>
        @endif
        @if($product->stock_quantity < 5 && $product->stock_quantity > 0)
            <span class="badge badge-stock-low position-absolute" style="top:12px;right:12px">Only {{ $product->stock_quantity }} left!</span>
        @endif
        <div class="card-body d-flex flex-column p-3">
            <p class="text-muted mb-1" style="font-size:.78rem">{{ $product->category->name }}</p>
            <h6 class="card-title fw-semibold mb-2">{{ $product->name }}</h6>
            <div class="mt-auto">
                <div class="d-flex align-items-center gap-2 mb-3">
                    @if(isset($discountPct) && $discountPct > 0)
                        <span class="fw-bold text-success" style="font-size:1.1rem">Rs. {{ number_format($product->price * (1 - $discountPct/100)) }}</span>
                        <span class="text-decoration-line-through text-muted small">Rs. {{ number_format($product->price) }}</span>
                        <span class="badge bg-danger ms-auto">-{{ $discountPct }}%</span>
                    @elseif($product->discount_price)
                        <span class="fw-bold text-success" style="font-size:1.1rem">Rs. {{ number_format($product->discount_price) }}</span>
                        <span class="text-decoration-line-through text-muted small">Rs. {{ number_format($product->price) }}</span>
                    @else
                        <span class="fw-bold text-success" style="font-size:1.1rem">Rs. {{ number_format($product->price) }}</span>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-green btn-sm flex-grow-1 rounded-pill">View</a>
                    @if($product->isInStock())
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        @auth
                        <button type="submit" class="btn btn-green btn-sm rounded-pill px-3"><i class="bi bi-bag-plus"></i></button>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-green btn-sm rounded-pill px-3"><i class="bi bi-bag-plus"></i></a>
                        @endauth
                    </form>
                    @else
                    <button class="btn btn-secondary btn-sm rounded-pill px-3" disabled>Out</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
