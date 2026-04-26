@extends('layouts.app')

@section('title', 'Complete Payment')

@section('content')
<style>

    .payment-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        max-width: 960px;
        margin: 0 auto;
    }


    .summary-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        height: fit-content;
    }

    .summary-card h2 {
        font-size: 20px;
        font-weight: 700;
        color: #222;
        margin-bottom: 24px;
    }

    .summary-room-box {
        background: #f8f8f8;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .summary-room-box .room-name {
        font-size: 18px;
        font-weight: 700;
        color: #222;
    }

    .summary-room-box .room-sub {
        font-size: 14px;
        color: #717171;
        margin-top: 4px;
    }


    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f1f1;
        font-size: 14px;
    }

    .price-row span:first-child {
        color: #717171;
    }

    .price-row span:last-child {
        color: #222;
    }

    .price-total {
        display: flex;
        justify-content: space-between;
        padding: 16px 0 0;
        font-size: 16px;
        font-weight: 700;
        color: #222;
    }

    .price-total .total-amount {
        font-size: 20px;
        color: #1a56db;
    }

    .summary-note {
        margin-top: 20px;
        background: #fffbeb;
        border: 1px solid #fcd34d;
        border-radius: 10px;
        padding: 14px 16px;
        font-size: 13px;
        color: #92400e;
    }


    .payment-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
    }

    .payment-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 28px;
    }

    .payment-icon {
        background: #1a56db;
        border-radius: 10px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .payment-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #222;
        margin: 0;
    }

    .payment-header p {
        font-size: 12px;
        color: #717171;
        margin: 0;
    }

    .visa-badge {
        background: #1a1f71;
        color: #fff;
        font-weight: 800;
        font-size: 13px;
        padding: 6px 14px;
        border-radius: 8px;
        letter-spacing: 1px;
        display: inline-block;
        margin-bottom: 28px;
    }


    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 14px 16px;
        border: 1.5px solid #ddd;
        border-radius: 10px;
        font-size: 15px;
        color: #222;
        outline: none;
        box-sizing: border-box;
    }

    .form-input:focus {
        border-color: #1a56db;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 28px;
    }


    .btn-pay {
        width: 100%;
        padding: 16px;
        background: #1a56db;
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        cursor: pointer;
    }

    .btn-pay:hover {
        background: #1648c0;
    }


    .secure-note {
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
        margin-top: 20px;
        font-size: 12px;
        color: #717171;
    }

    .cancel-link {
        display: block;
        text-align: center;
        margin-top: 16px;
        font-size: 13px;
        color: #717171;
        text-decoration: none;
    }

    .cancel-link:hover {
        color: #222;
    }

    @media (max-width: 768px) {
        .payment-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="page-hero">
    <h1>Secure Payment</h1>
    <p>Complete your payment to confirm your reservation at LaraHotel.</p>
</div>

<div class="payment-grid">

    <!-- Booking Summary -->
    <div class="summary-card">
        <h2>Booking Summary</h2>

        <div class="summary-room-box">
            <div class="room-name">{{ $booking->room->roomType->name }}</div>
            <div class="room-sub">Room {{ $booking->room->room_number }} - Floor {{ $booking->room->floor }}</div>
        </div>

        <div class="price-row">
            <span>Check-in</span>
            <span>{{ $booking->check_in->format('D, M d Y') }}</span>
        </div>
        <div class="price-row">
            <span>Check-out</span>
            <span>{{ $booking->check_out->format('D, M d Y') }}</span>
        </div>
        <div class="price-row">
            <span>Nights</span>
            <span>{{ $booking->nights }} night{{ $booking->nights === 1 ? '' : 's' }}</span>
        </div>
        <div class="price-row">
            <span>Guests</span>
            <span>{{ $booking->guests }}</span>
        </div>
        <div class="price-row">
            <span>Subtotal</span>
            <span>${{ number_format($booking->room->roomType->price_per_night * $booking->nights, 2) }}</span>
        </div>
        <div class="price-row">
            <span>Taxes (10%)</span>
            <span>${{ number_format($booking->room->roomType->price_per_night * $booking->nights * 0.10, 2) }}</span>
        </div>
        <div class="price-total">
            <span>Total</span>
            <span class="total-amount">${{ number_format($booking->total_price, 2) }}</span>
        </div>

        <div class="summary-note">
            Your room will be confirmed immediately after payment.
        </div>
    </div>

    <!-- Payment Form -->
    <div class="payment-card">

        <div class="payment-header">
            <div class="payment-icon">
                <svg width="24" height="24" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="1" y="4" width="22" height="16" rx="2"/>
                    <line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
            </div>
            <div>
                <h3>Card Payment</h3>
                <p>Secured with 256-bit SSL encryption</p>
            </div>
        </div>

        <div class="visa-badge">VISA</div>

        <form action="{{ route('payment.confirm', $booking) }}" method="POST" id="payment-form">
            @csrf

            <!-- Card Number -->
            <div class="form-group">
                <label class="form-label">Card Number</label>
                <input type="text" id="card-number" class="form-input"
                    placeholder="1234  5678  9012  3456"
                    maxlength="19"
                    style="letter-spacing:2px; font-family:monospace;"
                    oninput="formatCard(this)" required>
            </div>

            <!-- Cardholder Name -->
            <div class="form-group">
                <label class="form-label">Cardholder Name</label>
                <input type="text" class="form-input"
                    placeholder="JOHN DOE"
                    style="text-transform:uppercase;"
                    required>
            </div>

            <!-- Expiry + CVV -->
            <div class="form-row">
                <div>
                    <label class="form-label">Expiry Date</label>
                    <input type="text" class="form-input" placeholder="MM / YY"
                        maxlength="7" oninput="formatExpiry(this)" required>
                </div>
                <div>
                    <label class="form-label">CVV</label>
                    <input type="text" class="form-input" placeholder="•••"
                        maxlength="3" style="letter-spacing:4px;" required>
                </div>
            </div>

            <button type="submit" id="pay-btn" class="btn-pay">
                Pay ${{ number_format($booking->total_price, 2) }} Now
            </button>
        </form>

        <div class="secure-note">
            <svg width="16" height="16" fill="none" stroke="#717171" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="11" width="18" height="11" rx="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            Your payment information is encrypted and secure.
        </div>

        <a href="{{ route('home') }}" class="cancel-link">Cancel and return home</a>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function formatCard(input) {
        let val = input.value.replace(/\D/g, '').substring(0, 16);
        input.value = val.replace(/(.{4})/g, '$1  ').trim();
    }

    function formatExpiry(input) {
        let val = input.value.replace(/\D/g, '').substring(0, 4);
        if (val.length >= 2) val = val.substring(0, 2) + ' / ' + val.substring(2);
        input.value = val;
    }

    document.getElementById('pay-btn').addEventListener('click', function() {
        this.textContent = 'Processing...';
        this.style.opacity = '0.7';
        this.disabled = true;
        setTimeout(() => document.getElementById('payment-form').submit(), 1200);
    });
</script>
@endpush
