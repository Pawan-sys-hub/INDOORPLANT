@extends('layouts.app')
@section('title', 'Reset Password — GreenNest')

@section('content')
<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="p-4 p-md-5">
                    <div class="text-center mb-4">
                        <span class="d-inline-block bg-success bg-opacity-10 text-success rounded-circle p-3 mb-3">
                            <i class="bi bi-shield-lock fs-2"></i>
                        </span>
                        <h4 class="fw-bold section-title mb-1">Reset Password</h4>
                        <p class="text-muted small">Choose a new, secure password for your account.</p>
                    </div>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold small text-muted">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" readonly>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold small text-muted">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                <input id="password" type="password" class="form-control bg-light border-start-0 ps-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold small text-muted">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                                <input id="password_confirmation" type="password" class="form-control bg-light border-start-0 ps-0" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
                        </div>

                        <button type="submit" class="btn btn-green w-100 py-2 fw-semibold rounded-pill mb-3">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
