@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <h1 class="section-title mb-4">My Orders</h1>
    @if($orders->isEmpty())
    <div class="text-center py-5">
        <p style="font-size:4rem">📦</p>
        <h5 class="text-muted">No orders yet.</h5>
        <a href="{{ route('products.index') }}" class="btn btn-green mt-2">Start Shopping</a>
    </div>
    @else
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-success">
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Order Status</th>
                        <th>Payment</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><span class="fw-bold text-success">{{ $order->order_number }}</span></td>
                        <td class="text-muted small">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="text-muted small">{{ $order->items->count() }} items</td>
                        <td class="fw-bold">Rs. {{ number_format($order->total_amount) }}</td>
                        <td><span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->order_status) }}</span></td>
                        <td><span class="badge bg-{{ $order->payment_badge }}">{{ ucfirst($order->payment_status) }}</span></td>
                        <td><a href="{{ route('profile.order-detail', $order) }}" class="btn btn-outline-green btn-sm">View</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
