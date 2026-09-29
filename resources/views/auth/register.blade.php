@extends('layouts.app')
@section('title', 'Sign Up — GreenNest')

@section('content')
<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="p-4 p-md-5">
                    <div class="text-center mb-4">
                        <span class="d-inline-block bg-success bg-opacity-10 text-success rounded-circle p-3 mb-3">
                            <i class="bi bi-person-plus fs-2"></i>
                        </span>
                        <h4 class="fw-bold section-title mb-1">Create an Account</h4>
                        <p class="text-muted small">Join GreenNest and start shopping today.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold small text-muted">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                <input id="name" type="text" class="form-control bg-light border-start-0 ps-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" >
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger small" />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-muted">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="username">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label for="password" class="form-label fw-semibold small text-muted">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                    <input id="password" type="password" class="form-control bg-light border-start-0 ps-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="••••••••">
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                            </div>
                            <div class="col-sm-6">
                                <label for="password_confirmation" class="form-label fw-semibold small text-muted">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                                    <input id="password_confirmation" type="password" class="form-control bg-light border-start-0 ps-0" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-green w-100 py-2 fw-semibold rounded-pill mb-3">Sign up</button>
                        
                        <p class="text-center small text-muted mb-0">Already registered? <a href="{{ route('login') }}" class="text-success fw-semibold text-decoration-none">Log in</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
