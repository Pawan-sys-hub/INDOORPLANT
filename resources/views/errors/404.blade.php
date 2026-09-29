@extends('layouts.app')
@section('title', '404 — Page Not Found')

@section('content')
<div class="container py-5 text-center" style="min-height:55vh;display:flex;flex-direction:column;align-items:center;justify-content:center">
    <div class="mb-4" style="font-size:6rem;line-height:1">🌿</div>
    <h1 class="fw-bold display-4 text-success mb-2">404</h1>
    <h2 class="fw-semibold h4 mb-3 text-dark">Oops! This page has gone on a walk.</h2>
    <p class="text-muted mb-4" style="max-width:420px">
        The page you're looking for couldn't be found. It may have been moved, deleted, or never existed.
    </p>
    <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="{{ route('home') }}" class="btn btn-success px-4 rounded-pill">
            <i class="bi bi-house-door me-1"></i>Back to Home
        </a>
        <a href="{{ route('products.index') }}" class="btn btn-outline-success px-4 rounded-pill">
            <i class="bi bi-flower1 me-1"></i>Shop Plants
        </a>
    </div>
</div>
@endsection
