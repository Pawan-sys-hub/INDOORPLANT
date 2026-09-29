@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)
@section('page-title', 'Order Detail')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back to Orders
    </a>
    <div class="d-flex gap-2">
        @if($order->payment_status !== 'paid')
        <form method="POST" action="{{ route('admin.orders.mark-paid', $order) }}">
            @csrf
            <button class="btn btn-success btn-sm"><i class="bi bi-check-circle me-1"></i>Mark as Paid</button>
        </form>
        @endif
    </div>
</div>

<div class="row g-4">
    {{-- ORDER INFO --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">{{ $order->order_number }}</h5>
                        <span class="text-muted small">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="text-end">
                        @php
                            $pc = match($order->payment_status) { 'paid'=>'success','failed'=>'danger',default=>'warning' };
                            $sc = match($order->order_status) { 'delivered'=>'success','shipped'=>'info','processing'=>'primary','cancelled'=>'danger',default=>'secondary' };
                        @endphp
                        <span class="badge bg-{{ $pc }} me-1">{{ ucfirst($order->payment_status) }}</span>
                        <span class="badge bg-{{ $sc }}">{{ ucfirst($order->order_status) }}</span>
                    </div>
                </div>

                {{-- ITEMS --}}
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px"></th>
                                <th>Product</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                @if($item->product?->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded" style="width:48px;height:48px;object-fit:cover" alt="{{ $item->product_name }}">
                                @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:48px;height:48px;font-size:1.4rem">🌿</div>
                                @endif
                            </td>
                            <td>
                                <p class="mb-0 fw-semibold small">{{ $item->product_name }}</p>
                                @if($item->product)
                                <a href="{{ route('products.show', $item->product->slug) }}" class="text-success" style="font-size:.75rem" target="_blank">View</a>
                                @endif
                            </td>
                            <td class="text-end small">Rs. {{ number_format($item->unit_price) }}</td>
                            <td class="text-center small">{{ $item->quantity }}</td>
                            <td class="text-end fw-semibold small">Rs. {{ number_format($item->line_total) }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            @if($order->discount_amount > 0)
                            <tr>
                                <td colspan="4" class="text-end text-muted small">Discount</td>
                                <td class="text-end text-danger small">- Rs. {{ number_format($order->discount_amount) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total</td>
                                <td class="text-end fw-bold text-success">Rs. {{ number_format($order->total_amount) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- STATUS UPDATE --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-arrow-repeat me-1 text-success"></i>Update Order Status</h6>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="d-flex gap-3 align-items-end">
                    @csrf
                    <div class="flex-grow-1">
                        <select name="order_status" class="form-select">
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->order_status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>

    {{-- CUSTOMER INFO --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-person me-1 text-success"></i>Customer</h6>
                <p class="fw-semibold mb-1">{{ $order->user?->name ?? $order->full_name }}</p>
                <p class="text-muted small mb-1"><i class="bi bi-envelope me-1"></i>{{ $order->email }}</p>
                @if($order->phone)
                <p class="text-muted small mb-1"><i class="bi bi-telephone me-1"></i>{{ $order->phone }}</p>
                @endif
                @if($order->user)
                <a href="{{ route('admin.users.orders', $order->user) }}" class="btn btn-outline-success btn-sm mt-2 w-100">View All Orders</a>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt me-1 text-success"></i>Delivery Address</h6>
                <p class="small mb-0">{{ $order->address }}</p>
                @if($order->notes)
                <hr class="my-2">
                <p class="small text-muted mb-0"><strong>Note:</strong> {{ $order->notes }}</p>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-credit-card me-1 text-success"></i>Payment</h6>
                <div class="d-flex justify-content-between small mb-1">
                    <span class="text-muted">Method</span>
                    <span class="fw-semibold">{{ strtoupper($order->payment_method) }}</span>
                </div>
                <div class="d-flex justify-content-between small mb-1">
                    <span class="text-muted">Status</span>
                    <span class="badge bg-{{ $pc }}">{{ ucfirst($order->payment_status) }}</span>
                </div>
                @if($order->esewa_ref_id)
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">eSewa Ref</span>
                    <span class="fw-semibold" style="font-size:.72rem;word-break:break-all">{{ $order->esewa_ref_id }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
