@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="container py-5">
    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-success">Shop</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}?category={{ $product->category->slug }}" class="text-success">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- IMAGE --}}
        <div class="col-lg-5">
            <div class="position-sticky" style="top:90px">
                <div class="rounded-4 overflow-hidden shadow-sm" style="height:460px">
                    <img src="{{ $product->image_url }}" class="w-100 h-100" style="object-fit:cover;transition:transform .4s" id="mainImg" alt="{{ $product->name }}">
                </div>
                @if($product->is_featured)
                <div class="mt-3 text-center"><span class="badge bg-warning text-dark px-3 py-2">⭐ Featured Plant</span></div>
                @endif
            </div>
        </div>

        {{-- DETAILS --}}
        <div class="col-lg-7">
            <p class="text-muted mb-1">{{ $product->category->name }}</p>
            <h1 class="section-title mb-3" style="font-size:2rem">{{ $product->name }}</h1>

            {{-- PRICE --}}
            <div class="mb-4">
                @if($product->discount_price)
                    <span class="display-6 fw-bold text-success">Rs. {{ number_format($product->discount_price) }}</span>
                    <span class="h5 text-decoration-line-through text-muted ms-2">Rs. {{ number_format($product->price) }}</span>
                    <span class="badge bg-danger ms-2">SALE</span>
                @else
                    <span class="display-6 fw-bold text-success">Rs. {{ number_format($product->price) }}</span>
                @endif
            </div>

            {{-- STOCK --}}
            @if(!$product->isInStock())
                <div class="alert alert-danger py-2">❌ Out of Stock</div>
            @elseif($product->stock_quantity < 5)
                <div class="alert alert-warning py-2">⚠️ Only {{ $product->stock_quantity }} left in stock!</div>
            @else
                <div class="alert alert-success py-2">✅ In Stock ({{ $product->stock_quantity }} available)</div>
            @endif

            {{-- DESCRIPTION --}}
            @if($product->description)
            <p class="text-muted lh-lg mb-4">{{ $product->description }}</p>
            @endif

            {{-- ADD TO CART FORM --}}
            @auth
            @if($product->isInStock())
            <form method="POST" action="{{ route('cart.add') }}" class="mb-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <label class="fw-semibold">Quantity:</label>
                    <div class="input-group" style="width:130px">
                        <button type="button" class="btn btn-outline-secondary" onclick="changeQty(-1)" id="qtyMinus">−</button>
                        <input type="number" name="quantity" id="qty" class="form-control text-center" value="1" min="1" max="{{ $product->stock_quantity }}">
                        <button type="button" class="btn btn-outline-secondary" onclick="changeQty(1)" id="qtyPlus">+</button>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-green btn-lg px-5">
                        <i class="bi bi-bag-plus me-2"></i>Add to Cart
                    </button>
                    <a href="{{ route('checkout.index') }}" class="btn btn-outline-green btn-lg">Buy Now</a>
                </div>
            </form>
            @endif
            @else
            <div class="mb-4">
                <a href="{{ route('login') }}" class="btn btn-green btn-lg px-5">Login to Buy</a>
            </div>
            @endauth

            {{-- CARE INFO TABS --}}
            @if($product->light || $product->water || $product->difficulty)
            <div class="card border-0 bg-light rounded-4 p-4">
                <h6 class="fw-bold mb-3">🌿 Care Guide</h6>
                <div class="row text-center g-3">
                    @if($product->light)
                    <div class="col-4">
                        <div class="rounded-3 bg-white p-3 shadow-sm">
                            <p class="mb-1" style="font-size:1.5rem">☀️</p>
                            <p class="fw-semibold small mb-0">Light</p>
                            <p class="text-muted" style="font-size:.8rem">{{ $product->light }}</p>
                        </div>
                    </div>
                    @endif
                    @if($product->water)
                    <div class="col-4">
                        <div class="rounded-3 bg-white p-3 shadow-sm">
                            <p class="mb-1" style="font-size:1.5rem">💧</p>
                            <p class="fw-semibold small mb-0">Water</p>
                            <p class="text-muted" style="font-size:.8rem">{{ $product->water }}</p>
                        </div>
                    </div>
                    @endif
                    @if($product->difficulty)
                    <div class="col-4">
                        <div class="rounded-3 bg-white p-3 shadow-sm">
                            <p class="mb-1" style="font-size:1.5rem">🌱</p>
                            <p class="fw-semibold small mb-0">Difficulty</p>
                            <p class="text-muted" style="font-size:.8rem">{{ $product->difficulty }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- RELATED PRODUCTS --}}
    @if($related->count())
    <section class="mt-5 pt-4 border-top">
        <h4 class="section-title mb-4">You May Also Like</h4>
        <div class="row g-4">
            @foreach($related as $p)
                @include('partials.product-card', ['product' => $p, 'discountPct' => 0])
            @endforeach
        </div>
    </section>
    @endif
</div>

@section('scripts')
<script>
function changeQty(delta) {
    const el = document.getElementById('qty');
    const max = parseInt(el.max);
    const newVal = Math.min(Math.max(parseInt(el.value) + delta, 1), max);
    el.value = newVal;
}
</script>
@endsection
@endsection
