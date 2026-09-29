@extends('layouts.app')
@section('title', 'Shop All Plants')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- SIDEBAR FILTERS --}}
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-funnel me-2 text-success"></i>Filters</h5>
                <form action="{{ route('products.index') }}" method="GET">
                    <h6 class="fw-semibold small text-uppercase text-muted mb-2">Category</h6>
                    @foreach($categories as $cat)
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="category" id="cat_{{ $cat->slug }}" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }}>
                        <label class="form-check-label" for="cat_{{ $cat->slug }}">{{ $cat->name }}</label>
                    </div>
                    @endforeach
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="category" id="cat_all" value="" {{ !request('category') ? 'checked' : '' }}>
                        <label class="form-check-label" for="cat_all">All Categories</label>
                    </div>

                    <h6 class="fw-semibold small text-uppercase text-muted mb-2 mt-3">Price Range (NPR)</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-6"><input type="number" class="form-control form-control-sm" name="min_price" placeholder="Min" value="{{ request('min_price') }}"></div>
                        <div class="col-6"><input type="number" class="form-control form-control-sm" name="max_price" placeholder="Max" value="{{ request('max_price') }}"></div>
                    </div>

                    <h6 class="fw-semibold small text-uppercase text-muted mb-2">Sort By</h6>
                    <select name="sort" class="form-select form-select-sm mb-3">
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                        <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                    </select>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-green btn-sm">Apply Filters</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h4 section-title mb-0">
                    {{ request('category') ? ucwords(str_replace('-', ' ', request('category'))) : 'All Plants' }}
                </h1>
                <span class="text-muted small">{{ $products->total() }} plants found</span>
            </div>

            @if($products->isEmpty())
            <div class="text-center py-5">
                <p style="font-size:4rem">🌱</p>
                <h5 class="text-muted">No plants found for your filter.</h5>
                <a href="{{ route('products.index') }}" class="btn btn-green mt-3">Browse All</a>
            </div>
            @else
            <div class="row g-4">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product, 'discountPct' => 0])
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
