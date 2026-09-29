@extends('layouts.app')
@section('title', 'Shopping Cart')

@section('content')
<div class="container py-5">
    <h1 class="section-title mb-4">🛒 Shopping Cart</h1>

    @if(!$cart || $cart->items->isEmpty())
    <div class="text-center py-5">
        <p style="font-size:5rem">🌱</p>
        <h4 class="text-muted mb-3">Your cart is empty</h4>
        <p class="text-muted">Add some beautiful plants to get started!</p>
        <a href="{{ route('products.index') }}" class="btn btn-green btn-lg mt-2">Shop Plants</a>
    </div>
    @else
    <div class="row g-4">
        {{-- CART ITEMS --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    @foreach($cart->items as $item)
                    <div class="d-flex align-items-center p-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <img src="{{ $item->product->image_url }}" class="rounded-3 me-3" style="width:90px;height:90px;object-fit:cover" alt="{{ $item->product->name }}">
                        <div class="flex-grow-1">
                            <h6 class="fw-semibold mb-1">{{ $item->product->name }}</h6>
                            <p class="text-muted small mb-2">{{ $item->product->category->name }}</p>
                            <p class="text-success fw-bold mb-0">Rs. {{ number_format($item->product->effective_price) }} each</p>
                        </div>
                        <div class="d-flex align-items-center gap-3 ms-3">
                            {{-- Quantity Form --}}
                            <form method="POST" action="{{ route('cart.update', $item) }}" class="d-flex align-items-center gap-1">
                                @csrf @method('PATCH')
                                <div class="input-group" style="width:110px">
                                    <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" class="btn btn-outline-secondary btn-sm">−</button>
                                    <input type="number" name="quantity" class="form-control form-control-sm text-center" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}" onchange="this.form.submit()">
                                    <button type="submit" name="quantity" value="{{ min($item->quantity + 1, $item->product->stock_quantity) }}" class="btn btn-outline-secondary btn-sm">+</button>
                                </div>
                            </form>
                            <p class="fw-bold mb-0" style="min-width:80px;text-align:right">Rs. {{ number_format($item->line_total) }}</p>
                            <form method="POST" action="{{ route('cart.remove', $item) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Remove this item?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ORDER SUMMARY --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 position-sticky" style="top:90px">
                <h5 class="fw-bold mb-3">Order Summary</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span><span>Rs. {{ number_format($subtotal) }}</span>
                </div>
                @if($discountPct > 0)
                <div class="d-flex justify-content-between text-danger mb-2">
                    <span>Discount ({{ $discountPct }}%)</span><span>−Rs. {{ number_format($discount) }}</span>
                </div>
                @endif
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                    <span>Total</span><span class="text-success">Rs. {{ number_format($total) }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-green w-100 btn-lg">Proceed to Checkout →</a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">Continue Shopping</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
