@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center mx-auto mb-3" style="width:80px;height:80px;font-size:2rem;color:#fff">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h6 class="fw-bold">{{ $user->name }}</h6>
                <p class="text-muted small">{{ $user->email }}</p>
                <hr>
                <a href="{{ route('profile.orders') }}" class="btn btn-outline-green btn-sm w-100">My Orders</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">Edit Profile</h5>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Delivery Address</label>
                            <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted">Email (cannot change)</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-green mt-4">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
