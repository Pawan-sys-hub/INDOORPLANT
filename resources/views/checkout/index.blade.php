@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h1 class="section-title mb-4">🛍️ Checkout</h1>
    <div class="row g-5">
        {{-- CHECKOUT FORM --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm">
                    @csrf
                    <h5 class="fw-bold mb-4">Delivery Information</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name', $user->name) }}" required>
                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone *</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Delivery Address *</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', $user->address) }}</textarea>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="fw-bold mb-3">Payment Method</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="radio" class="btn-check" name="payment_method" id="esewa" value="esewa" checked>
                            <label class="btn btn-outline-success w-100 p-3 text-start" for="esewa">
                                <div class="d-flex align-items-center gap-2">
                                    <span style="font-size:1.5rem">💚</span>
                                    <div>
                                        <p class="fw-bold mb-0">eSewa</p>
                                        <p class="small text-muted mb-0">Secure digital payment</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input type="radio" class="btn-check" name="payment_method" id="cod" value="cod">
                            <label class="btn btn-outline-secondary w-100 p-3 text-start" for="cod">
                                <div class="d-flex align-items-center gap-2">
                                    <span style="font-size:1.5rem">💵</span>
                                    <div>
                                        <p class="fw-bold mb-0">Cash on Delivery</p>
                                        <p class="small text-muted mb-0">Pay when delivered</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-green w-100 btn-lg mt-4">
                        <i class="bi bi-lock me-2"></i>Place Order
                    </button>
                </form>
            </div>
        </div>

        {{-- ORDER SUMMARY --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 position-sticky" style="top:90px">
                <h5 class="fw-bold mb-3">Order Summary</h5>
                @foreach($cart->items as $item)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ $item->product->image_url }}" class="rounded-2" style="width:56px;height:56px;object-fit:cover" alt="">
                    <div class="flex-grow-1">
                        <p class="fw-semibold small mb-0">{{ Str::limit($item->product->name, 28) }}</p>
                        <p class="text-muted small mb-0">× {{ $item->quantity }}</p>
                    </div>
                    <span class="fw-bold small">Rs. {{ number_format($item->line_total) }}</span>
                </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between mb-1 small text-muted">
                    <span>Subtotal</span><span>Rs. {{ number_format($subtotal) }}</span>
                </div>
                @if($discountPct > 0)
                <div class="d-flex justify-content-between mb-1 small text-danger">
                    <span>Discount ({{ $discountPct }}%)</span><span>−Rs. {{ number_format($discount) }}</span>
                </div>
                @endif
                <div class="d-flex justify-content-between mb-1 small text-muted">
                    <span>Delivery</span><span class="text-success fw-semibold">FREE</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span><span class="text-success">Rs. {{ number_format($total) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
