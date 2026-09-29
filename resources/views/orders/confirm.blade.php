@extends('layouts.app')
@section('title', 'Order Confirmed — '.$order->order_number)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 text-center p-5">
                @if($order->payment_status === 'paid')
                    <p style="font-size:4rem">✅</p>
                    <h2 class="section-title mb-2">Payment Successful!</h2>
                    <p class="text-muted mb-4">Your order has been placed and payment confirmed.</p>
                @else
                    <p style="font-size:4rem">🌿</p>
                    <h2 class="section-title mb-2">Order Placed!</h2>
                    <p class="text-muted mb-4">Thank you! Our team will contact you to arrange delivery.</p>
                @endif

                <div class="bg-light rounded-4 p-4 mb-4 text-start">
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="text-muted small mb-0">Order Number</p>
                            <p class="fw-bold text-success mb-0">{{ $order->order_number }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted small mb-0">Payment</p>
                            <span class="badge bg-{{ $order->payment_badge }} px-2 py-1">{{ ucfirst($order->payment_status) }}</span>
                        </div>
                        <div class="col-6">
                            <p class="text-muted small mb-0">Method</p>
                            <p class="fw-semibold mb-0">{{ strtoupper($order->payment_method) }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted small mb-0">Total</p>
                            <p class="fw-bold mb-0">Rs. {{ number_format($order->total_amount) }}</p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted small mb-0">Delivery to</p>
                            <p class="fw-semibold mb-0">{{ $order->address }}</p>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold text-start mb-3">Items Ordered</h6>
                @foreach($order->items as $item)
                <div class="d-flex justify-content-between align-items-center mb-2 py-2 border-bottom text-start">
                    <div>
                        <p class="fw-semibold mb-0">{{ $item->product_name }}</p>
                        <p class="text-muted small mb-0">× {{ $item->quantity }} @ Rs. {{ number_format($item->unit_price) }}</p>
                    </div>
                    <span class="fw-bold">Rs. {{ number_format($item->line_total) }}</span>
                </div>
                @endforeach

                <div class="d-flex gap-3 justify-content-center mt-4">
                    <a href="{{ route('profile.orders') }}" class="btn btn-outline-green px-4">View My Orders</a>
                    <a href="{{ route('products.index') }}" class="btn btn-green px-4">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
