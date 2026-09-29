@extends('layouts.app')
@section('title', 'GreenNest — Premium Indoor Plants')

@section('content')

{{-- HERO --}}
<section class="hero-section text-white">
    <div class="container position-relative" style="z-index:1">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-up">
                <p class="text-success-emphasis fw-semibold mb-2 opacity-75" style="color:#a5d6a7 !important;letter-spacing:2px;font-size:.85rem">🌿 FREE DELIVERY IN KATHMANDU VALLEY</p>
                <h1 class="display-4 fw-bold mb-3" style="font-family:'Playfair Display',serif;line-height:1.15">
                    {{ $heroHeadline }}
                </h1>
                <p class="lead mb-4 opacity-85" style="font-size:1.1rem">{{ $heroSubtext }}</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg px-4 fw-bold text-success">Shop Plants <i class="bi bi-arrow-right ms-1"></i></a>
                    <a href="{{ route('products.index') }}?category=air-purifying" class="btn btn-outline-light btn-lg px-4">Air Purifiers</a>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <div class="d-flex justify-content-center gap-4 mt-4">
                    @foreach($categories->take(3) as $cat)
                    <a href="{{ route('products.index') }}?category={{ $cat->slug }}" class="text-decoration-none">
                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.12);transition:.2s" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                            <p class="mb-1" style="font-size:2.5rem">{{ $cat->icon }}</p>
                            <p class="small text-white fw-semibold mb-0">{{ $cat->name }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TRUST STRIP --}}
<div class="trust-strip py-3">
    <div class="container">
        <div class="row text-center">
            <div class="col-4"><span class="fw-semibold"><i class="bi bi-truck me-2"></i>Free Delivery KTM</span></div>
            <div class="col-4"><span class="fw-semibold"><i class="bi bi-shield-check me-2"></i>Secure eSewa Pay</span></div>
            <div class="col-4"><span class="fw-semibold"><i class="bi bi-arrow-return-left me-2"></i>Easy Returns</span></div>
        </div>
    </div>
</div>

{{-- CATEGORIES --}}
<section class="container my-5">
    <h2 class="section-title text-center mb-4">Shop by Category</h2>
    <div class="row g-3 justify-content-center">
        @foreach($categories as $cat)
        <div class="col-6 col-sm-4 col-md-2">
            <a href="{{ route('products.index') }}?category={{ $cat->slug }}" class="category-card d-block text-center p-3">
                <p class="icon mb-1">{{ $cat->icon }}</p>
                <p class="mb-0 small fw-semibold text-dark">{{ $cat->name }}</p>
                <p class="mb-0" style="font-size:.75rem;color:#888">{{ $cat->products_count }} plants</p>
            </a>
        </div>
        @endforeach
    </div>
</section>

{{-- NEW ARRIVALS --}}
<section class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">New Arrivals</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-green rounded-pill px-3">View All <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
    <div class="row g-4">
        @foreach($newArrivals as $product)
            @include('partials.product-card', ['product' => $product, 'discountPct' => $discountPct])
        @endforeach
    </div>
</section>

{{-- BEST SELLERS --}}
@if($bestSellers->count())
<section class="py-5" style="background:var(--green-pale)">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">🏆 Best Sellers</h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-green rounded-pill px-3">View All</a>
        </div>
        <div class="row g-4">
            @foreach($bestSellers as $product)
                @include('partials.product-card', ['product' => $product, 'discountPct' => $discountPct])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA BANNER --}}
<section class="container my-5">
    <div class="rounded-4 p-5 text-center" style="background:linear-gradient(135deg,#1B5E20,#2E7D32);color:#fff">
        <h2 class="fw-bold mb-2" style="font-family:'Playfair Display',serif">Ready to Go Green? 🌱</h2>
        <p class="mb-4 opacity-85">Browse our full catalog of 30+ handpicked indoor plants.</p>
        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg px-5 fw-bold text-success">Shop Now</a>
    </div>
</section>

@endsection
