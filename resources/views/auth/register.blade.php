@extends('layouts.app')

@section('title', 'Register')

@section('content')

    <div class="auth-page-layout">
        <div class="auth-left-image">
            <img src="{{ asset('images/hotel-lounge.png') }}" alt="Hotel Interior">
        </div>
        <div class="auth-right-form">
            <div class="auth-card register-card">
                <h2>Create Account</h2>
                <p>Join LaraHotel and unlock exclusive member benefits.</p>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    @if($errors->any())
                        <div style="background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; padding:12px 16px; border-radius:10px; margin-bottom:20px; font-size:13px; text-align:left;">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" placeholder="John"
                                value="{{ old('first_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" placeholder="Doe"
                                value="{{ old('last_name') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="you@domain.com"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Min. 8 characters" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-reserve" style="margin-top: 10px;">Create Account</button>

                    <p style="margin-top: 30px; margin-bottom: 0;">
                        Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign In</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

@endsection
