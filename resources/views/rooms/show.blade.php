@extends('layouts.app')

@section('title', $roomType->name)

@section('content')
<style>

    .room-rules {
        margin-bottom: 0;
    }


    .no-image-box {
        width: 100%;
        height: 100%;
        background: var(--light-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-text);
        font-size: 15px;
        font-weight: 700;
    }


    .booking-errors {
        background: #fee2e2;
        border: 1px solid #fca5a5;
        color: #991b1b;
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 13px;
    }


    .select-disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }


    .redirect-note {
        text-align: center;
        font-size: 12px;
        color: var(--gray-text);
        margin-top: 16px;
    }


    .panel-center-box {
        text-align: center;
        padding: 20px 0;
    }

    .panel-center-box p {
        color: var(--gray-text);
        font-size: 14px;
        margin-bottom: 20px;
    }

    .btn-reserve-block {
        display: block;
        text-decoration: none;
    }
</style>

<div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp;
    <a href="{{ route('rooms.index') }}">Rooms</a> &nbsp;/&nbsp;
    {{ $roomType->name }}
</div>

<!-- GALLERY -->
<div class="room-gallery">
    <div class="room-gallery-item main-item">
        @if($roomType->image_url)
            <img src="{{ asset($roomType->image_url) }}" alt="{{ $roomType->name }}">
        @else
            <div class="no-image-box">No image</div>
        @endif
    </div>
    <div class="room-gallery-col">
        <div class="room-gallery-item">
            <img src="{{ asset('images/room-gallery-interior.png') }}" alt="Interior">
        </div>
        <div class="room-gallery-item">
            <img src="{{ asset('images/room-gallery-bathroom.png') }}" alt="Bathroom">
        </div>
    </div>
</div>

<div class="page-layout">

    <!-- LEFT: Room Details -->
    <div class="room-details-content">
        <div class="room-header">
            <h1>{{ $roomType->name }}</h1>
            <div class="room-meta-tags">
                <div class="meta-tag">Size: {{ $roomType->size_sqft }} Sq Ft</div>
                <div class="meta-tag">Guests: Up to {{ $roomType->max_guests }}</div>
                <div class="meta-tag">Category: {{ $roomType->roomCategory?->name ?? $roomType->category }}</div>
            </div>
        </div>

        <p class="room-desc">{{ $roomType->description }}</p>

        <h3 class="section-title">Premium In-Room Amenities</h3>
        <div class="amenities-grid">
            <div class="amenity-item"><div class="amenity-icon"></div> Fast Fiber Wi-Fi</div>
            <div class="amenity-item"><div class="amenity-icon"></div> Deep Soaking Tub</div>
            <div class="amenity-item"><div class="amenity-icon"></div> Platinum Mini Bar</div>
            <div class="amenity-item"><div class="amenity-icon"></div> 75" Smart OLED TV</div>
            <div class="amenity-item"><div class="amenity-icon"></div> Electronic Smart Safe</div>
            <div class="amenity-item"><div class="amenity-icon"></div> Daily Deep Cleaning</div>
        </div>


    </div>

    <!-- RIGHT: Booking Panel -->
    <aside>
        <div class="booking-panel">
            <div class="booking-price">${{ number_format($roomType->price_per_night, 0) }} <span>/ night</span></div>

            @auth
                @php $availableRooms = $roomType->availableRooms; @endphp

                @if($availableRooms->count() > 0)
                    <form action="{{ route('bookings.store', $roomType) }}" method="POST" id="booking-form">
                        @csrf

                        @if($errors->any())
                            <div class="booking-errors">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        @php
                            $roomsByFloor = $availableRooms->groupBy('floor')->sortKeys();
                            $oldRoomId    = old('room_id');
                            $oldFloor     = $oldRoomId
                                ? $availableRooms->firstWhere('id', $oldRoomId)?->floor
                                : null;
                        @endphp

                        <!-- Floor selector -->
                        <div class="form-group">
                            <label>Select Floor</label>
                            <select id="floor-select" onchange="filterRooms(this.value)">
                                <option value="">- Choose a Floor -</option>
                                @foreach($roomsByFloor as $floor => $rooms)
                                    <option value="{{ $floor }}" {{ $oldFloor == $floor ? 'selected' : '' }}>
                                        Floor {{ $floor }} ({{ $rooms->count() }} room{{ $rooms->count() > 1 ? 's' : '' }} available)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Room selector -->
                        <div class="form-group">
                            <label>Select Room</label>
                            <select name="room_id" id="room-select" required class="select-disabled" disabled>
                                <option value="">- Select a floor first -</option>
                            </select>
                        </div>

                        <script>
                            const roomsByFloor = @json($roomsByFloor->map(fn($rooms) => $rooms->map(fn($r) => ['id' => $r->id, 'number' => $r->room_number])->values()));
                            const oldRoomId    = {{ $oldRoomId ? $oldRoomId : 'null' }};

                            function filterRooms(floor) {
                                const sel = document.getElementById('room-select');
                                sel.innerHTML = '';

                                if (!floor || !roomsByFloor[floor]) {
                                    sel.innerHTML = '<option value="">- Select a floor first -</option>';
                                    sel.disabled = true;
                                    sel.className = 'select-disabled';
                                    return;
                                }

                                sel.innerHTML = '<option value="">- Choose a Room -</option>';
                                roomsByFloor[floor].forEach(function(room) {
                                    var opt = document.createElement('option');
                                    opt.value       = room.id;
                                    opt.textContent = 'Room ' + room.number;
                                    if (room.id === oldRoomId) opt.selected = true;
                                    sel.appendChild(opt);
                                });

                                sel.disabled = false;
                                sel.className = '';
                            }

                            // Restore floor + room on validation error
                            document.addEventListener('DOMContentLoaded', function() {
                                var floorSel = document.getElementById('floor-select');
                                if (floorSel.value) filterRooms(floorSel.value);
                            });
                        </script>

                        <!-- Dates -->
                        <div class="form-group">
                            <label>Check In</label>
                            <input type="date" name="check_in" id="check_in"
                                value="{{ old('check_in', date('Y-m-d', strtotime('+1 day'))) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Check Out</label>
                            <input type="date" name="check_out" id="check_out"
                                value="{{ old('check_out', date('Y-m-d', strtotime('+4 days'))) }}" required>
                        </div>

                        <!-- Guests -->
                        <div class="form-group">
                            <label>Guests</label>
                            <select name="guests">
                                @for($i = 1; $i <= $roomType->max_guests; $i++)
                                    <option value="{{ $i }}" {{ old('guests', 1) == $i ? 'selected' : '' }}>
                                        {{ $i }} {{ $i === 1 ? 'Adult' : 'Adults' }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="price-breakdown">
                            <div class="price-row">
                                <span id="nightly-label">${{ number_format($roomType->price_per_night, 0) }} x 3 nights</span>
                                <span id="subtotal">${{ number_format($roomType->price_per_night * 3, 0) }}</span>
                            </div>
                            <div class="price-row">
                                <span>Taxes (10%)</span>
                                <span id="taxes">${{ number_format($roomType->price_per_night * 3 * 0.10, 0) }}</span>
                            </div>
                            <div class="price-total">
                                <span>Total Price</span>
                                <span id="total">${{ number_format($roomType->price_per_night * 3 * 1.10, 0) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-reserve">Reserve &amp; Pay</button>
                        <p class="redirect-note">You will be redirected to the payment page.</p>
                    </form>

                @else
                    <!-- No rooms available -->
                    <div class="panel-center-box">
                        <p>No rooms available for this type right now.</p>
                        <a href="{{ route('rooms.index') }}" class="btn-reserve btn-reserve-block">View Other Rooms</a>
                    </div>
                @endif

            @else
                <!-- Not logged in -->
                <div class="panel-center-box">
                    <p>Please log in to make a reservation.</p>
                    <a href="{{ route('login') }}" class="btn-reserve btn-reserve-block">Sign In to Reserve</a>
                    <p style="margin-top:16px; font-size:12px;">
                        No account? <a href="{{ route('register') }}" class="auth-link">Register Now</a>
                    </p>
                </div>
            @endauth
        </div>
    </aside>

</div>

@endsection

@push('scripts')
<script>
    const pricePerNight = {{ $roomType->price_per_night }};

    function updatePrice() {
        const checkIn  = new Date(document.getElementById('check_in').value);
        const checkOut = new Date(document.getElementById('check_out').value);
        if (isNaN(checkIn) || isNaN(checkOut) || checkOut <= checkIn) return;

        const nights   = Math.round((checkOut - checkIn) / 86400000);
        const subtotal = pricePerNight * nights;
        const taxes    = Math.round(subtotal * 0.10);
        const total    = subtotal + taxes;

        document.getElementById('nightly-label').textContent = '$' + pricePerNight.toLocaleString() + ' x ' + nights + ' night' + (nights > 1 ? 's' : '');
        document.getElementById('subtotal').textContent = '$' + subtotal.toLocaleString();
        document.getElementById('taxes').textContent = '$' + taxes.toLocaleString();
        document.getElementById('total').textContent = '$' + total.toLocaleString();
    }

    document.getElementById('check_in')?.addEventListener('change', updatePrice);
    document.getElementById('check_out')?.addEventListener('change', updatePrice);
</script>
@endpush
