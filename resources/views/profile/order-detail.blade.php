@extends('layouts.app')
@section('title', 'Order '.$order->order_number)

@section('content')
<div class="container py-5">
    <a href="{{ route('profile.orders') }}" class="btn btn-outline-secondary btn-sm mb-4"><i class="bi bi-arrow-left me-1"></i>Back to Orders</a>
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="section-title mb-1">{{ $order->order_number }}</h4>
                <p class="text-muted small">Placed {{ $order->created_at->format('F d, Y') }}</p>
            </div>
            <div class="text-end">
                <span class="badge bg-{{ $order->status_badge }} me-1 py-2 px-3">{{ ucfirst($order->order_status) }}</span>
                <span class="badge bg-{{ $order->payment_badge }} py-2 px-3">{{ ucfirst($order->payment_status) }}</span>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-8">
                <h6 class="fw-bold mb-3">Items</h6>
                @foreach($order->items as $item)
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                    <div>
                        <p class="fw-semibold mb-0">{{ $item->product_name }}</p>
                        <p class="text-muted small mb-0">× {{ $item->quantity }} @ Rs. {{ number_format($item->unit_price) }}</p>
                    </div>
                    <span class="fw-bold">Rs. {{ number_format($item->line_total) }}</span>
                </div>
                @endforeach
                <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                    <span>Total</span><span class="text-success">Rs. {{ number_format($order->total_amount) }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-light rounded-4 p-4">
                    <h6 class="fw-bold mb-3">Delivery Info</h6>
                    <p class="mb-1 fw-semibold">{{ $order->full_name }}</p>
                    <p class="mb-1 text-muted small">{{ $order->phone }}</p>
                    <p class="mb-1 text-muted small">{{ $order->email }}</p>
                    <p class="mb-1 text-muted small">{{ $order->address }}</p>
                    <hr>
                    <p class="mb-0 small"><strong>Payment:</strong> {{ strtoupper($order->payment_method) }}</p>
                    @if($order->esewa_ref_id)
                    <p class="mb-0 small text-muted"><strong>eSewa Ref:</strong> {{ $order->esewa_ref_id }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
