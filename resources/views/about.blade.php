@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<style>

    .about-heading {
        font-size: 36px;
        margin-bottom: 24px;
    }


    .about-text {
        color: var(--gray-text);
        font-size: 16px;
        line-height: 1.8;
        margin-bottom: 24px;
    }


    .building-banner {
        margin-top: 60px;
        border-radius: 20px;
        overflow: hidden;
        max-height: 500px;
    }

    .building-banner img {
        width: 100%;
        height: 500px;
        object-fit: cover;
        object-position: center;
    }
</style>

<div class="page-hero">
    <h1>Our Story</h1>
    <p>Discover the rich history behind our world-class luxury hotel.</p>
</div>

<div class="about-grid">

    <!-- About Text -->
    <div class="about-content">
        <h2 class="about-heading">Redefining Luxury Since 2010</h2>
        <p class="about-text">
            LaraHotel was founded with a single, clear vision: to create an absolute haven of unparalleled luxury. Over the last decade, we have seamlessly bridged the gap between timeless elegance and modern technological conveniences.
        </p>
        <p class="about-text">
            Every element of our hotel is constructed to evoke serenity. From our personalized concierge systems to hand-picked art pieces throughout the corridors, our focus remains on providing guests with a memorable, customized experience.
        </p>
        <a href="{{ route('rooms.index') }}" class="btn-black">View Our Suites</a>
    </div>

    <!-- About Images -->
    <div class="about-images">
        <img src="{{ asset('images/hotel-lounge.png') }}" alt="Hotel Lounge">
        <img src="{{ asset('images/hotel-service.png') }}" alt="Premium Service">
    </div>

</div>

<!-- Hotel Building Photo -->
<div class="building-banner">
    <img src="{{ asset('images/hotel-building.png') }}" alt="LaraHotel Exterior">
</div>

@endsection
