@extends('layouts.app')

@section('title', 'Rooms')

@section('content')
<style>

    .rooms-page-hero {
        text-align: center;
        margin: 40px 0 60px;
    }

    .rooms-page-hero h1 {
        font-size: 48px;
        margin-bottom: 16px;
    }

    .rooms-page-hero p {
        color: var(--gray-text);
        max-width: 600px;
        margin: 0 auto;
    }


    .filter-row {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-bottom: 50px;
    }


    .room-bed-type {
        margin-top: 8px;
        font-size: 13px;
        color: var(--gray-text);
    }


    .room-price-row {
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .room-price-amount {
        font-weight: 700;
        font-size: 18px;
        color: var(--primary-blue);
    }

    .room-price-amount span {
        font-size: 12px;
        color: var(--gray-text);
        font-weight: 400;
    }

    .room-available-count {
        font-size: 12px;
        color: var(--gray-text);
    }


    .no-image-placeholder {
        width: 100%;
        height: 240px;
        background: var(--light-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-text);
        font-size: 15px;
        font-weight: 700;
        border-radius: 20px;
        margin-bottom: 16px;
    }


    .rooms-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 0;
        color: var(--gray-text);
    }

    .rooms-empty p {
        font-size: 18px;
    }


    .btn-filter-inactive {
        border-color: #eee;
        color: var(--gray-text);
    }
</style>

<!-- Page Hero -->
<div class="rooms-page-hero">
    <h1>Exquisite Accommodations</h1>
    <p>Choose from our carefully curated selection of suites and rooms, each designed to provide the ultimate sanctuary.</p>
</div>

<!-- Filter Buttons -->
<div class="filter-row">
    <a href="{{ route('rooms.index') }}"
        class="{{ !$category ? 'btn-black' : 'btn-outline btn-filter-inactive' }}">All Rooms</a>
    @foreach($categories as $roomCategory)
        <a href="{{ route('rooms.index', ['category' => $roomCategory->name]) }}"
            class="{{ $category === $roomCategory->name ? 'btn-black' : 'btn-outline btn-filter-inactive' }}">
            {{ $roomCategory->name }}
        </a>
    @endforeach
</div>

<!-- Rooms Grid -->
<div class="rooms-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 100px;">
    @forelse($roomTypes as $type)
        <div class="room-card" onclick="window.location.href='{{ route('rooms.show', $type) }}'">

            @if($type->image_url)
                <img src="{{ asset($type->image_url) }}" alt="{{ $type->name }}">
            @else
                <div class="no-image-placeholder">No image</div>
            @endif

            <div class="room-info">
                <div>
                    <div class="room-title">{{ $type->name }}</div>
                    <div class="room-meta">
                        <span>{{ $type->max_guests }} Guests</span> &bull; <span>{{ $type->size_sqft }} Sq Ft</span>
                    </div>
                    <div class="room-bed-type">{{ $type->bed_type ?: 'Bed details coming soon' }}</div>
                </div>
                <div class="rating-pill">{{ $type->rating }}</div>
            </div>

            <div class="room-price-row">
                <div class="room-price-amount">
                    ${{ number_format($type->price_per_night, 0) }}
                    <span>/ night</span>
                </div>
                <div class="room-available-count">
                    {{ $type->available_rooms_count ?? $type->availableRooms->count() }} available
                </div>
            </div>

        </div>
    @empty
        <div class="rooms-empty">
            <p>No rooms available at the moment.</p>
        </div>
    @endforelse
</div>

@endsection
