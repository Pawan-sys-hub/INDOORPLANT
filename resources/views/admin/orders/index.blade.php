@extends('layouts.admin')
@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
{{-- FILTER BAR --}}
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
    <form class="row g-2 align-items-end" method="GET" action="{{ route('admin.orders.index') }}">
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Search by Order # or Name</label>
            <input type="text" name="q" class="form-control form-control-sm" placeholder="ORD-..." value="{{ request('q') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Payment Status</label>
            <select name="payment" class="form-select form-select-sm">
                <option value="">All</option>
                <option value="pending"  {{ request('payment')=='pending'  ?'selected':'' }}>Pending</option>
                <option value="paid"     {{ request('payment')=='paid'     ?'selected':'' }}>Paid</option>
                <option value="failed"   {{ request('payment')=='failed'   ?'selected':'' }}>Failed</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Order Status</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">All</option>
                <option value="pending"    {{ request('status')=='pending'    ?'selected':'' }}>Pending</option>
                <option value="processing" {{ request('status')=='processing' ?'selected':'' }}>Processing</option>
                <option value="shipped"    {{ request('status')=='shipped'    ?'selected':'' }}>Shipped</option>
                <option value="delivered"  {{ request('status')=='delivered'  ?'selected':'' }}>Delivered</option>
                <option value="cancelled"  {{ request('status')=='cancelled'  ?'selected':'' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-success btn-sm w-100">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">✕</a>
        </div>
    </form>
</div>

{{-- TABLE --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        @if($orders->isEmpty())
        <div class="text-center py-5">
            <p style="font-size:3rem">📦</p>
            <h5 class="text-muted">No orders found.</h5>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle admin-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="fw-semibold small">{{ $order->order_number }}</td>
                    <td class="small">
                        {{ $order->user?->name ?? $order->full_name }}<br>
                        <span class="text-muted" style="font-size:.75rem">{{ $order->email }}</span>
                    </td>
                    <td class="fw-bold">Rs. {{ number_format($order->total_amount) }}</td>
                    <td>
                        @php
                            $pc = match($order->payment_status) {
                                'paid'   => 'success',
                                'failed' => 'danger',
                                default  => 'warning',
                            };
                        @endphp
                        <span class="badge bg-{{ $pc }}">{{ ucfirst($order->payment_status) }}</span>
                    </td>
                    <td class="small">{{ strtoupper($order->payment_method) }}</td>
                    <td>
                        @php
                            $sc = match($order->order_status) {
                                'delivered'  => 'success',
                                'shipped'    => 'info',
                                'processing' => 'primary',
                                'cancelled'  => 'danger',
                                default      => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $sc }}">{{ ucfirst($order->order_status) }}</span>
                    </td>
                    <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-eye"></i> View
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $orders->appends(request()->query())->links() }}</div>
        @endif
    </div>
</div>
@endsection
