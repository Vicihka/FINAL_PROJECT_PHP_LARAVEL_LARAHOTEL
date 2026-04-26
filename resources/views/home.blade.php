@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <!-- HERO -->
    <section class="hero">
        <img src="{{ asset('images/hero-hotel.png') }}"
            alt="Hotel Pool" class="hero-bg-img">
        <div class="hero-pagination">
            <div class="page-dot active">1</div>
            <div class="page-dot">2</div>
            <div class="page-dot">3</div>
        </div>
        <div class="hero-content">
            <p class="hero-subtitle">ELEVATE YOUR STAY</p>
            <h1 class="hero-title">Experience Ultimate Luxury &amp; Comfort!</h1>
            <a href="{{ route('rooms.index') }}" class="btn-blue">
                Book A Room Now <span class="icon-play"></span>
            </a>
        </div>
        <form action="{{ route('rooms.index') }}" method="GET" class="booking-search">
            <div class="search-field">
                <label>Check In</label>
                <input type="date" name="check_in" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>
            <div class="search-field">
                <label>Check Out</label>
                <input type="date" name="check_out" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
            </div>
            <div class="search-field">
                <label>Guests</label>
                <select name="guests">
                    <option>1 Adult</option>
                    <option selected>2 Adults</option>
                    <option>2 Adults, 1 Child</option>
                    <option>Family Suite</option>
                </select>
            </div>
            <div class="search-field">
                <label>Room Category</label>
                <select name="category">
                    <option value="">All Rooms</option>
                    @foreach($categories as $roomCategory)
                        <option value="{{ $roomCategory->name }}">{{ $roomCategory->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-blue search-btn">Check Availability</button>
        </form>
    </section>

    <!-- FEATURED ROOMS -->
    <section class="featured-rooms">
        <div class="section-header">
            <div>
                <h2>Signature Rooms &amp; Suites</h2>
                <p>Unleash Your Comfort With LaraHotel. Click any room to view full details.</p>
            </div>
            <div class="slider-nav">
                <button>&lt;</button>
                <button class="active">&gt;</button>
            </div>
        </div>
        <div class="rooms-carousel">
            <div class="rooms-grid" style="grid-template-columns: repeat(3, 1fr);">
                @forelse($featuredRooms as $type)
                    <div class="room-card" onclick="window.location.href='{{ route('rooms.show', $type) }}'">
                        @if($type->image_url)
                            <img src="{{ asset($type->image_url) }}" alt="{{ $type->name }}">
                        @else
                            <div style="width:100%; height:240px; background:var(--light-blue); display:flex; align-items:center; justify-content:center; color:var(--gray-text); font-size:15px; font-weight:700; border-radius:24px; margin-bottom:16px;">No image</div>
                        @endif
                        <div class="room-info">
                            <div>
                                <h3 class="room-title">{{ $type->name }}</h3>
                                <p class="room-meta">{{ $type->roomCategory?->name ?? $type->category }} - {{ $type->bed_type ?: 'Bed info coming soon' }}</p>
                            </div>
                            <div class="rating-pill">{{ $type->rating }}</div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column:1/-1; text-align:center; padding:60px; color:var(--gray-text);">
                        <p>No rooms added yet. Check back soon!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection
