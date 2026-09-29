@extends('layouts.app')
@section('title', 'Login — GreenNest')

@section('content')
<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="p-4 p-md-5">
                    <div class="text-center mb-4">
                        <span class="d-inline-block bg-success bg-opacity-10 text-success rounded-circle p-3 mb-3">
                            <i class="bi bi-box-arrow-in-right fs-2"></i>
                        </span>
                        <h4 class="fw-bold section-title mb-1">Welcome Back!</h4>
                        <p class="text-muted small">Log in to manage your orders.</p>
                    </div>

                    <x-auth-session-status class="mb-4 text-success fw-semibold text-center small" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold small text-muted">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold small text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                <input id="password" type="password" class="form-control bg-light border-start-0 ps-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                <label class="form-check-label text-muted small" for="remember_me">Remember me</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-success small fw-semibold text-decoration-none" href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-green w-100 py-2 fw-semibold rounded-pill mb-3">Log in</button>
                        
                        <p class="text-center small text-muted mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-success fw-semibold text-decoration-none">Sign up</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
