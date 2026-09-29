<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GreenNest') — Bring Nature Home</title>
    <meta name="description" content="@yield('meta_description', 'GreenNest — Premium indoor plants delivered in Kathmandu Valley. Shop air-purifying, succulents, flowering plants and more.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --green-primary: #2E7D32;
            --green-dark: #1B5E20;
            --green-light: #4CAF50;
            --green-pale: #E8F5E9;
            --green-accent: #81C784;
        }
        * { font-family: 'Inter', sans-serif; }
        body { background: #FAFAFA; color: #1a1a1a; font-size: 1.08rem; line-height: 1.65; }

        /* NAVBAR */
        .navbar-brand { font-family: 'Playfair Display', serif; font-size: 1.7rem; color: var(--green-primary) !important; font-weight: 700; letter-spacing: -0.5px; }
        .navbar-floating { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border: 1px solid rgba(46, 125, 50, 0.1); border-radius: 100px; padding: 0.6rem 1.5rem; margin-top: 1rem; position: sticky; top: 1rem; z-index: 1030; box-shadow: 0 8px 32px rgba(46, 125, 50, 0.08); transition: all 0.3s ease; }
        
        .nav-link { color: #4a4a4a !important; font-weight: 500; padding: 0.5rem 1rem !important; border-radius: 50px; transition: all 0.25s ease; font-size: 1rem; display: flex; align-items: center; gap: 0.4rem; }
        .nav-link:hover { color: var(--green-primary) !important; background: var(--green-pale); transform: translateY(-1px); }
        .nav-item.dropdown .dropdown-menu { border: none; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); padding: 0.8rem; margin-top: 10px; }
        .dropdown-item { border-radius: 8px; padding: 0.6rem 1rem; font-size: 0.95rem; font-weight: 500; transition: all 0.2s; }
        .dropdown-item:hover { background: var(--green-pale); color: var(--green-primary); }

        /* CART ICON ANIMATION */
        .cart-icon-wrapper { position: relative; transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .nav-link:hover .cart-icon-wrapper { transform: scale(1.15) rotate(-5deg); }

        /* BUTTONS */
        .btn-green { background: var(--green-primary); color: #fff; border: none; font-weight: 600; }
        .btn-green:hover { background: var(--green-dark); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(46,125,50,0.3); }
        .btn-outline-green { border: 2px solid var(--green-primary); color: var(--green-primary); font-weight: 600; background: transparent; }
        .btn-outline-green:hover { background: var(--green-primary); color: #fff; }

        /* CARDS */
        .product-card { border: none; border-radius: 16px; overflow: hidden; transition: transform .25s, box-shadow .25s; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .product-card:hover { transform: translateY(-6px); box-shadow: 0 12px 32px rgba(46,125,50,0.15); }
        .product-card__img { height: 220px; object-fit: cover; transition: transform .4s; }
        .product-card:hover .product-card__img { transform: scale(1.04); }
        .product-card__badge { position: absolute; top: 12px; left: 12px; font-size: .72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }

        /* TOASTS */
        .toast-container { position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 1055; }

        /* SECTIONS */
        .section-title { font-family: 'Playfair Display', serif; color: var(--green-dark); }
        .category-card { border-radius: 16px; background: var(--green-pale); border: 2px solid transparent; transition: all .2s; cursor: pointer; text-decoration: none; }
        .category-card:hover { border-color: var(--green-primary); background: #fff; transform: translateY(-3px); }
        .category-card .icon { font-size: 2.2rem; }

        /* TRUST STRIP */
        .trust-strip { background: var(--green-primary); color: #fff; }

        /* BADGES */
        .badge-stock-low { background: #fff3e0; color: #e65100; font-size: .75rem; }

        /* FOOTER */
        footer { background: var(--green-dark); color: rgba(255,255,255,0.85); }
        footer a { color: var(--green-accent); text-decoration: none; }
        footer a:hover { color: #fff; }

        /* PAGINATION */
        .page-link { color: var(--green-primary); }
        .page-item.active .page-link { background: var(--green-primary); border-color: var(--green-primary); }

        /* HERO */
        .hero-section { min-height: 540px; display: flex; align-items: center; position: relative; background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 50%, #388E3C 100%); }
        .hero-section::after { content:''; position:absolute; inset:0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); pointer-events:none; }

        /* TRANSITION ANIMATIONS */
        .fade-up { animation: fadeUp .5s ease; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }

        /* FORM */
        .form-control:focus, .form-select:focus { border-color: var(--green-primary); box-shadow: 0 0 0 .25rem rgba(46,125,50,.15); }

        @yield('styles')
    </style>
</head>
<body>

{{-- NAVBAR --}}
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-floating">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span style="font-size: 1.8rem; line-height: 1;">🌿</span> GreenNest
        </a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            {{-- SEARCH --}}
            <form class="d-flex mx-auto my-3 my-lg-0" style="max-width: 380px; width: 100%" action="{{ route('products.search') }}" method="GET">
                <div class="input-group">
                    <input class="form-control border-success border-end-0 bg-light rounded-start-pill ps-4" type="search" name="q" placeholder="Search indoor plants…" aria-label="Search" value="{{ request('q') }}">
                    <button class="btn btn-green rounded-end-pill px-4" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>

            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">
                        <i class="bi bi-shop"></i> Shop All
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <div class="cart-icon-wrapper">
                                <i class="bi bi-cart3 fs-5"></i>
                                @php
                                    $cartQty = \App\Models\Cart::where('user_id', auth()->id())->with('items')->first()?->items?->sum('quantity') ?? 0;
                                @endphp
                                @if($cartQty)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-2 border-white" style="font-size:.6rem; margin-top:2px;">{{ $cartQty }}</span>
                                @endif
                            </div>
                            <span class="d-lg-none ms-2">Cart</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5 text-success"></i> 
                            <span class="fw-semibold">{{ Str::limit(auth()->user()->name, 12) }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bi bi-person me-2 text-muted"></i>My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.orders') }}"><i class="bi bi-bag-check me-2 text-muted"></i>My Orders</a></li>
                            @if(auth()->user()->isAdmin())
                            <li><hr class="dropdown-divider opacity-25"></li>
                            <li>
                                <a class="dropdown-item text-success fw-bold bg-success bg-opacity-10" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Admin Panel
                                </a>
                            </li>
                            @endif
                            <li><hr class="dropdown-divider opacity-25"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-green rounded-pill px-4 fw-semibold shadow-sm" href="{{ route('register') }}">Sign Up</a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
</div>

{{-- FLASH MESSAGES (toast) --}}
@if(session('success') || session('error'))
<div class="toast-container">
    <div id="flashToast" class="toast show align-items-center border-0 {{ session('success') ? 'text-bg-success' : 'text-bg-danger' }}" role="alert">
        <div class="d-flex">
            <div class="toast-body fw-semibold">
                <i class="bi {{ session('success') ? 'bi-check-circle' : 'bi-exclamation-triangle' }} me-2"></i>
                {{ session('success') ?? session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif

{{-- PAGE CONTENT --}}
<main>
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="mt-5 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-bold text-white mb-3">🌿 GreenNest</h5>
                <p class="small opacity-75">Premium indoor plants delivered to your door in Kathmandu Valley. Bring nature home.</p>
            </div>
            <div class="col-md-2">
                <h6 class="text-white fw-semibold mb-3">Shop</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('products.index') }}">All Plants</a></li>
                    <li><a href="{{ route('products.index') }}?category=air-purifying">Air-Purifying</a></li>
                    <li><a href="{{ route('products.index') }}?category=succulent">Succulents</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6 class="text-white fw-semibold mb-3">Account</h6>
                <ul class="list-unstyled small">
                    @auth
                    <li><a href="{{ route('profile.index') }}">My Profile</a></li>
                    <li><a href="{{ route('profile.orders') }}">My Orders</a></li>
                    @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="text-white fw-semibold mb-3">Stay Updated</h6>
                <div class="input-group mb-2">
                    <input type="email" class="form-control" placeholder="your@email.com">
                    <button class="btn btn-green">Subscribe</button>
                </div>
                <p class="small opacity-60">🇳🇵 Kathmandu Valley delivery only</p>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="d-flex justify-content-between small opacity-60">
            <span>&copy; {{ date('Y') }} GreenNest. All rights reserved.</span>
            <span>Secure payments via <strong>eSewa</strong></span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto-dismiss toast after 4s
document.addEventListener('DOMContentLoaded', () => {
    const toast = document.getElementById('flashToast');
    if (toast) setTimeout(() => bootstrap.Toast.getOrCreateInstance(toast).hide(), 4000);
});
</script>
@yield('scripts')
</body>
</html>
