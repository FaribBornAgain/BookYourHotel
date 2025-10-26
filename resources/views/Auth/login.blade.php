@extends('layouts.master')

@section('title', 'Login - BookYourHotel')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">Login to BookYourHotel</h3>
                    </div>
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>
                            </div>

                            <hr class="my-4">

                            <div class="text-center">
                                <p class="mb-2">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-decoration-none">
                                            Forgot Your Password?
                                        </a>
                                    @endif
                                </p>
                                <p class="mb-0">
                                    Don't have an account? 
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                                        Register Now
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Continue as Guest -->
                <div class="card mt-3 shadow-sm">
                    <div class="card-body text-center">
                        <p class="mb-2"><strong>Don't want to create an account?</strong></p>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-user"></i> Continue as Guest
                        </a>
                        <p class="text-muted small mt-2">You can still book rooms without an account</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection