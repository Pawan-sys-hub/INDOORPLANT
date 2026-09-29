@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- STAT CARDS --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card card shadow-sm p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#E8F5E9;color:#2E7D32">🌿</div>
                <div>
                    <p class="text-muted small mb-0">Total Products</p>
                    <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card card shadow-sm p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#E3F2FD;color:#1565C0">📦</div>
                <div>
                    <p class="text-muted small mb-0">Total Orders</p>
                    <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card card shadow-sm p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#FFF3E0;color:#E65100">💰</div>
                <div>
                    <p class="text-muted small mb-0">Total Revenue (Paid)</p>
                    <h3 class="fw-bold mb-0">Rs. {{ number_format($totalRevenue) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CHART + RECENT ORDERS --}}
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold mb-3">Orders — Last 7 Days</h6>
            <canvas id="ordersChart" height="140"></canvas>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between mb-3">
                <h6 class="fw-bold mb-0">Recent Orders</h6>
                <a href="{{ route('admin.orders.index') }}" class="small text-success">View all</a>
            </div>
            @foreach($recentOrders as $order)
            <a href="{{ route('admin.orders.show', $order) }}" class="d-flex align-items-center justify-content-between mb-3 text-decoration-none text-dark">
                <div>
                    <p class="fw-semibold mb-0 small">{{ $order->order_number }}</p>
                    <p class="text-muted mb-0" style="font-size:.78rem">{{ $order->user?->name ?? $order->full_name }}</p>
                </div>
                <div class="text-end">
                    <p class="fw-bold small mb-0">Rs. {{ number_format($order->total_amount) }}</p>
                    <span class="badge bg-{{ $order->payment_badge }}" style="font-size:.7rem">{{ $order->payment_status }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

@section('scripts')
<script>
const ctx = document.getElementById('ordersChart').getContext('2d');
new Chart(ctx, {
    type:'bar',
    data:{
        labels: {!! json_encode($chartLabels) !!},
        datasets:[{
            label:'Orders',
            data: {!! json_encode($chartValues) !!},
            backgroundColor:'rgba(46,125,50,0.7)',
            borderRadius:8,
        }]
    },
    options:{ plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true, ticks:{stepSize:1}}} }
});
</script>
@endsection
@endsection
