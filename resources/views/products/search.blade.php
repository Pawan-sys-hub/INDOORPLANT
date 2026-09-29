@extends('layouts.app')
@section('title', 'Search: '.$q)

@section('content')
<div class="container py-5">
    <h1 class="section-title mb-1">Search Results</h1>
    <p class="text-muted mb-4">{{ $products->total() }} plants found for "<strong>{{ $q }}</strong>"</p>

    @if($products->isEmpty())
    <div class="text-center py-5">
        <p style="font-size:4rem">🔍</p>
        <h5 class="text-muted">No plants found for "{{ $q }}"</h5>
        <p class="text-muted">Try a different search term or browse our full catalog.</p>
        <a href="{{ route('products.index') }}" class="btn btn-green mt-2">Browse All Plants</a>
    </div>
    @else
    <div class="row g-4">
        @foreach($products as $product)
            @include('partials.product-card', ['product' => $product, 'discountPct' => 0])
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
    @endif
</div>
@endsection
