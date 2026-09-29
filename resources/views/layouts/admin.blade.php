<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — GreenNest</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --green:#2E7D32; --green-dark:#1B5E20; --sidebar-w:260px; }
        * { font-family:'Inter',sans-serif; }
        body { background:#f0f4f0; }

        /* SIDEBAR */
        .sidebar { width:var(--sidebar-w); background:var(--green-dark); min-height:100vh; position:fixed; left:0; top:0; z-index:100; transition:.3s; }
        .sidebar-brand { background:var(--green); padding:1.2rem 1.5rem; font-size:1.3rem; font-weight:700; color:#fff; }
        .sidebar-nav { padding:.5rem 0; }
        .sidebar-link { display:flex; align-items:center; gap:.75rem; padding:.7rem 1.5rem; color:rgba(255,255,255,.75); font-size:.9rem; font-weight:500; text-decoration:none; transition:.15s; border-left:3px solid transparent; }
        .sidebar-link:hover, .sidebar-link.active { color:#fff; background:rgba(255,255,255,.1); border-left-color:#81C784; }
        .sidebar-link i { width:20px; text-align:center; font-size:1.05rem; }

        /* MAIN */
        .admin-main { margin-left:var(--sidebar-w); }
        .admin-topbar { background:#fff; padding:.85rem 1.5rem; border-bottom:1px solid #e0ebe0; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:50; }
        .admin-content { padding:1.5rem; }

        /* CARDS */
        .stat-card { border:none; border-radius:16px; background:#fff; }
        .stat-card .icon-box { width:56px; height:56px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; }

        /* TABLE */
        .admin-table th { font-weight:600; font-size:.82rem; text-transform:uppercase; letter-spacing:.5px; color:#666; }

        /* FORM */
        .form-control:focus, .form-select:focus { border-color:var(--green); box-shadow:0 0 0 .2rem rgba(46,125,50,.15); }

        /* TOAST */
        .toast-container { position:fixed; bottom:1rem; right:1rem; z-index:9999; }

        /* PAGINATION */
        .page-link { color:var(--green); font-size:.85rem; padding:.3rem .6rem; }
        .page-item.active .page-link { background:var(--green); border-color:var(--green); }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-brand">🌿 GreenNest</div>
    <div class="sidebar-nav">
        <p class="mx-3 mt-3 mb-1" style="font-size:.7rem;color:rgba(255,255,255,.4);letter-spacing:1px;text-transform:uppercase">Menu</p>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active':'' }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active':'' }}"><i class="bi bi-flower1"></i> Products</a>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active':'' }}"><i class="bi bi-bag-check"></i> Orders</a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active':'' }}"><i class="bi bi-people"></i> Customers</a>
        <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active':'' }}"><i class="bi bi-gear"></i> Settings</a>
        <hr style="border-color:rgba(255,255,255,.15);margin:.75rem 1rem">
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank"><i class="bi bi-box-arrow-up-right"></i> View Store</a>
    </div>
</aside>

{{-- MAIN --}}
<div class="admin-main">
    <div class="admin-topbar">
        <h6 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>
    <div class="admin-content">
        @if(session('success') || session('error'))
        <div class="toast-container">
            <div class="toast show text-bg-{{ session('success') ? 'success' : 'danger' }} border-0">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">{{ session('success') ?? session('error') }}</div>
                    <button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toast = document.querySelector('.toast');
    if (toast) setTimeout(() => bootstrap.Toast.getOrCreateInstance(toast).hide(), 4000);
});
</script>
@yield('scripts')
</body>
</html>
