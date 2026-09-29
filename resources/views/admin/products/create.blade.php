@extends('layouts.admin')
@section('title', 'Add Product')
@section('page-title', 'Add New Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Back</a>
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin.products._form')
                <button type="submit" class="btn btn-success mt-4 px-5">Create Product</button>
            </form>
        </div>
    </div>
</div>
@endsection
