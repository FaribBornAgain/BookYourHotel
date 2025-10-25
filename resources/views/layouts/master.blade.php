<!-- File: resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Hebat')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #f39c12;
            --light-bg: #ecf0f1;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color) !important;
        }
        
        .nav-link {
            color: var(--primary-color) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: var(--secondary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            border: none;
            padding: 10px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #e67e22;
            transform: translateY(-2px);
        }
        
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%234a90e2" width="1200" height="600"/><path fill="%2355a3e8" d="M0 300L50 280C100 260 200 220 300 200C400 180 500 180 600 200C700 220 800 260 900 280C1000 300 1100 300 1150 300L1200 300V600H0Z"/></svg>');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 150px 0;
            text-align: center;
        }
        
        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .hero-section p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        
        .card {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 30px;
        }
        
        .card:hover {
            transform: translateY(-10px);
        }
        
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }
        
        .price-badge {
            background-color: var(--secondary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 1.3rem;
            font-weight: bold;
        }
        
        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 50px 0 20px;
            margin-top: 80px;
        }
        
        .footer-section h5 {
            color: var(--secondary-color);
            margin-bottom: 20px;
        }
        
        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: color 0.3s;
        }
        
        .social-icons a:hover {
            color: var(--secondary-color);
        }
        
        .alert {
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .facility-card {
            background-color: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            color: white;
            margin: 15px 0;
            transition: all 0.3s;
        }
        
        .facility-card:hover {
            background-color: rgba(255,255,255,0.2);
            transform: scale(1.05);
        }
        
        .facility-card i {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">HOME</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('facilities') }}">FACILITIES</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('about') }}">ABOUT US</a>
        </li>
        
       @auth
    <!-- Logged in user menu -->
    @if(Auth::user()->isBusiness())
        <!-- Business User Menu -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('business.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> DASHBOARD
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('business.hotels.index') }}">
                <i class="fas fa-hotel"></i> MY HOTELS
            </a>
        </li>
    @else
        <!-- Guest User Menu -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('reservations.my') }}">
                <i class="fas fa-calendar-check"></i> MY RESERVATIONS
            </a>
        </li>
    @endif
    
    @auth
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
            @if(Auth::user()->isBusiness())
                <span class="badge bg-success">Business</span>
            @endif
            @if(Auth::user()->isAdmin())
                <span class="badge bg-danger">Admin</span>
            @endif
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
            
            @if(Auth::user()->isAdmin())
                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-cog"></i> Admin Dashboard
                </a></li>
                <li><hr class="dropdown-divider"></li>
            @endif
            
            @if(Auth::user()->isBusiness())
                <li><a class="dropdown-item" href="{{ route('business.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a></li>
                <li><a class="dropdown-item" href="{{ route('business.hotels.index') }}">
                    <i class="fas fa-hotel"></i> My Hotels
                </a></li>
            @else
                <li><a class="dropdown-item" href="{{ route('reservations.my') }}">
                    <i class="fas fa-list"></i> My Bookings
                </a></li>
            @endif
            
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </li>
@endauth
@else
    <!-- Guest menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">
            <i class="fas fa-sign-in-alt"></i> LOGIN
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link btn btn-primary text-white ms-2" href="{{ route('register') }}">
            <i class="fas fa-user-plus"></i> REGISTER
        </a>
    </li>
@endauth
    </ul>
</div>
    </nav>

    <!-- Main Content -->
    <main style="padding-top: 80px;">
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-section">
                    <h5>ABOUT AGENCY</h5>
                    <p>The world has become so fast paced that people don't want to stand by reading a page of information, they would much rather look at a presentation and understand the message. It has come to a point.</p>
                </div>
                <div class="col-md-4 footer-section">
                    <h5>NEWSLETTER</h5>
                    <p>For business professionals caught between high OEM price and mediocre print and graphic output.</p>
                </div>
                <div class="col-md-4 footer-section">
                    <h5>INSTAFEED</h5>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2); margin: 30px 0;">
            <div class="text-center">
                <p>&copy; 2024 Hotel Hebat. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>