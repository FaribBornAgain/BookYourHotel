@extends('layouts.master')

@section('title', 'Register - Hotel Hebat')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">Create Your Account</h3>
                    </div>
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Account Type Selection -->
                            <div class="mb-4">
                                <label class="form-label"><strong>Account Type</strong></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card h-100 border-2 cursor-pointer account-type-card" onclick="selectAccountType('guest')">
                                            <div class="card-body text-center">
                                                <input type="radio" name="user_type" id="guest_type" value="guest" 
                                                       class="form-check-input" {{ old('user_type') == 'guest' ? 'checked' : 'checked' }}>
                                                <label for="guest_type" class="d-block cursor-pointer">
                                                    <i class="fas fa-user fa-3x text-primary mb-3"></i>
                                                    <h5>Guest Account</h5>
                                                    <p class="text-muted small">For personal bookings and vacations</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card h-100 border-2 cursor-pointer account-type-card" onclick="selectAccountType('business')">
                                            <div class="card-body text-center">
                                                <input type="radio" name="user_type" id="business_type" value="business" 
                                                       class="form-check-input" {{ old('user_type') == 'business' ? 'checked' : '' }}>
                                                <label for="business_type" class="d-block cursor-pointer">
                                                    <i class="fas fa-briefcase fa-3x text-success mb-3"></i>
                                                    <h5>Business Account</h5>
                                                    <p class="text-muted small">For corporate and business travel</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('user_type')
                                    <span class="text-danger small">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password">
                                <small class="text-muted">Minimum 8 characters</small>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" 
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus"></i> Create Account
                                </button>
                            </div>

                            <hr class="my-4">

                            <div class="text-center">
                                <p class="mb-0">
                                    Already have an account? 
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                        Login Here
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.cursor-pointer {
    cursor: pointer;
}
.account-type-card:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    transform: translateY(-5px);
    transition: all 0.3s;
}
.account-type-card input[type="radio"]:checked ~ label {
    color: var(--primary-color);
}
</style>

<script>
function selectAccountType(type) {
    document.getElementById(type + '_type').checked = true;
}
</script>
@endsection