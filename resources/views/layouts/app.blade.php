<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LaraHotel') - Luxury Stays</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

        .alert-success {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #166534;
            padding: 14px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-error {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 14px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }


        .bell-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1.5px solid #ddd;
            background: #fff;
            text-decoration: none;
        }

        .bell-btn:hover {
            border-color: #999;
        }

        .bell-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }


        .nav-greeting {
            font-size: 14px;
            color: #717171;
            font-weight: 500;
        }


        .logout-form {
            display: inline;
        }


        .newsletter-desc {
            color: #9ca3af;
            font-size: 14px;
            margin-bottom: 12px;
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="container">

        <!-- NAVBAR -->
        <nav>
            <a href="{{ route('home') }}" class="logo">
                <div class="logo-icon"></div>
                LaraHotel
            </a>
            <div class="nav-center-links">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active-link' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active-link' : '' }}">About</a>
                <a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.*') ? 'active-link' : '' }}">Rooms</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active-link' : '' }}">Contact</a>
            </div>
            <div class="nav-auth-links">
                @auth
                    @if(! auth()->user()->is_admin)
                        <a href="{{ route('bookings.my') }}" class="btn-outline {{ request()->routeIs('bookings.my') ? 'active-link' : '' }}">My Bookings</a>
                        @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                        <!-- Notification Bell -->
                        <a href="{{ route('notifications.index') }}" class="bell-btn" title="Notifications">
                            <svg width="18" height="18" fill="none" stroke="#374151" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 0 0-5-5.917V4a1 1 0 1 0-2 0v1.083A6 6 0 0 0 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/>
                            </svg>
                            @if($unread > 0)
                                <span class="bell-badge">{{ $unread }}</span>
                            @endif
                        </a>
                    @endif
                    <span class="nav-greeting">Hi, {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="btn-outline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-outline {{ request()->routeIs('login') ? 'active-link' : '' }}">Login</a>
                    <a href="{{ route('register') }}" class="btn-outline {{ request()->routeIs('register') ? 'active-link' : '' }}">Sign Up</a>
                @endauth
            </div>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')

    </div>

    <!-- GLOBAL FOOTER -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="logo">
                        <div class="logo-icon"></div>
                        LaraHotel
                    </a>
                    <p>Experience the epitome of luxury, breathtaking views, and unparalleled hospitality at LaraHotel. Your comfort is our top priority.</p>
                </div>

                <div class="footer-links-col">
                    <h4 class="footer-title">Quick Links</h4>
                    <div class="footer-links">
                        <a href="{{ route('home') }}">Home Overview</a>
                        <a href="{{ route('about') }}">About LaraHotel</a>
                        <a href="{{ route('rooms.index') }}">Our Rooms</a>
                        <a href="{{ route('contact') }}">Contact & Location</a>
                    </div>
                </div>

                <div class="footer-links-col">
                    <h4 class="footer-title">Support</h4>
                    <div class="footer-links">
                        <a href="{{ route('login') }}">Account Login</a>
                        <a href="{{ route('register') }}">Guest Registration</a>
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms of Service</a>
                    </div>
                </div>

                <div class="footer-newsletter">
                    <h4 class="footer-title">Newsletter</h4>
                    <p class="newsletter-desc">Subscribe to receive premium deals and updates directly to your inbox.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault();">
                        <input type="email" placeholder="Enter your email" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} LaraHotel Systems. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">English (US)</a>
                    <a href="#">USD ($)</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
