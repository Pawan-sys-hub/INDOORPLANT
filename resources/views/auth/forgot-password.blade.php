@extends('layouts.app')
@section('title', 'Forgot Password — GreenNest')

@section('content')
<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="p-4 p-md-5">
                    <div class="text-center mb-4">
                        <span class="d-inline-block bg-success bg-opacity-10 text-success rounded-circle p-3 mb-3">
                            <i class="bi bi-key fs-2"></i>
                        </span>
                        <h4 class="fw-bold section-title mb-2">Forgot Password?</h4>
                        <p class="text-muted small">No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                    </div>

                    <x-auth-session-status class="mb-4 text-success fw-semibold text-center small" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email address">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                        </div>

                        <button type="submit" class="btn btn-green w-100 py-2 fw-semibold rounded-pill mb-3">
                            Email Password Reset Link
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
