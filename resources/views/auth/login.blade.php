@extends('layouts.app')

@section('title', ($isAdminLogin ?? false) ? 'Admin Login' : 'Login')

@section('content')

    <div class="auth-page-layout">
        <div class="auth-left-image">
            <img src="{{ asset('images/hotel-lounge.png') }}" alt="Hotel Interior">
        </div>
        <div class="auth-right-form">
            <div class="auth-card">
                <h2>{{ ($isAdminLogin ?? false) ? 'Admin Portal' : 'Welcome Back' }}</h2>
                <p>
                    {{ ($isAdminLogin ?? false)
                        ? 'Sign in to access the hotel administration dashboard.'
                        : 'Log in to access your bookings and premium benefits.' }}
                </p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    @if($isAdminLogin ?? false)
                        <input type="hidden" name="admin_portal" value="1">
                    @endif

                    @if($errors->any())
                        <div style="background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; padding:12px 16px; border-radius:10px; margin-bottom:20px; font-size:13px; text-align:left;">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="you@domain.com"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--gray-text); cursor: pointer; text-transform: none; font-weight: 500;">
                            <input type="checkbox" name="remember" style="width: auto;"> Remember me
                        </label>
                        <a href="#" class="auth-link" style="font-weight: 500;">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn-reserve" style="margin-top: 0;">Sign In</button>

                    @unless($isAdminLogin ?? false)
                        <p style="margin-top: 30px; margin-bottom: 0;">
                            Don't have an account? <a href="{{ route('register') }}" class="auth-link">Register Now</a>
                        </p>
                    @endunless
                </form>

                @if($isAdminLogin ?? false)
                    <p style="margin-top: 20px; font-size:12px; color:var(--gray-text);">
                        Admin URL: {{ route('admin.login') }}
                    </p>
                @endif
            </div>
        </div>
    </div>

@endsection
