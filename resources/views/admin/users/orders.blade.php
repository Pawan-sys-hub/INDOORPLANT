@extends('layouts.admin')
@section('title', 'Orders — ' . $user->name)
@section('page-title', 'Customer Orders')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Customers
    </a>
    <div>
        <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
        <p class="text-muted small mb-0">{{ $user->email }}</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        @if($orders->isEmpty())
        <div class="text-center py-5">
            <p style="font-size:3rem">📦</p>
            <h5 class="text-muted">This customer has no orders yet.</h5>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle admin-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order #</th>
                        <th class="text-center">Items</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="fw-semibold small">{{ $order->order_number }}</td>
                    <td class="text-center small">{{ $order->items->count() }}</td>
                    <td class="fw-bold">Rs. {{ number_format($order->total_amount) }}</td>
                    <td>
                        @php $pc = match($order->payment_status) { 'paid'=>'success','failed'=>'danger',default=>'warning' }; @endphp
                        <span class="badge bg-{{ $pc }}">{{ ucfirst($order->payment_status) }}</span>
                    </td>
                    <td>
                        @php $sc = match($order->order_status) { 'delivered'=>'success','shipped'=>'info','processing'=>'primary','cancelled'=>'danger',default=>'secondary' }; @endphp
                        <span class="badge bg-{{ $sc }}">{{ ucfirst($order->order_status) }}</span>
                    </td>
                    <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
@endsection
