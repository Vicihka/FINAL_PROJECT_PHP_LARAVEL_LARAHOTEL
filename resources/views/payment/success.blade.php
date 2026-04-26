@extends('layouts.app')

@section('title', 'Payment Successful')

@push('styles')
<style>

    @media print {
        nav, footer, .no-print { display: none !important; }
        .container { padding: 0 !important; }
        .receipt-card { box-shadow: none !important; border: 1px solid #ddd !important; }
        body { background: white !important; }
    }


    .success-banner {
        text-align: center;
        margin-bottom: 32px;
    }

    .success-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 72px;
        height: 72px;
        background: #dcfce7;
        border-radius: 50%;
        margin-bottom: 16px;
    }

    .success-banner h1 {
        font-size: 28px;
        font-weight: 800;
        color: #222;
    }

    .success-banner p {
        color: #717171;
        margin-top: 8px;
        font-size: 15px;
    }


    .receipt-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        max-width: 680px;
        margin: 0 auto;
    }

    .receipt-header {
        background: #f0fdf4;
        border-bottom: 1px solid #bbf7d0;
        padding: 32px;
        text-align: center;
        color: #14532d;
    }

    .receipt-header .hotel-name {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .receipt-header .receipt-label {
        font-size: 13px;
        color: #16a34a;
        margin-top: 4px;
    }

    .receipt-ref {
        margin-top: 16px;
        background: #fff;
        border: 1px solid #86efac;
        color: #15803d;
        display: inline-block;
        padding: 8px 20px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .receipt-body {
        padding: 32px;
    }


    .section-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #9ca3af;
        margin-bottom: 10px;
    }

    .divider {
        border: none;
        border-top: 1px dashed #ddd;
        margin: 20px 0;
    }


    .guest-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 24px;
    }

    .guest-grid .label {
        font-size: 12px;
        color: #717171;
    }

    .guest-grid .value {
        font-size: 15px;
        font-weight: 600;
        color: #222;
        margin-top: 2px;
    }


    .room-info-box {
        background: #f8f8f8;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 24px;
    }

    .room-info-box .room-name {
        font-size: 17px;
        font-weight: 700;
        color: #222;
    }

    .room-info-box .room-sub {
        font-size: 13px;
        color: #717171;
        margin-top: 4px;
    }

    .room-dates-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
        margin-top: 16px;
    }

    .room-dates-grid .date-label {
        font-size: 11px;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .room-dates-grid .date-value {
        font-size: 14px;
        font-weight: 600;
        color: #222;
        margin-top: 4px;
    }


    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 14px;
    }

    .price-row span:first-child {
        color: #717171;
    }

    .price-row.border-top {
        border-top: 1px solid #f1f1f1;
    }

    .price-final {
        display: flex;
        justify-content: space-between;
        padding: 16px 0 0;
        border-top: 2px solid #ddd;
        margin-top: 8px;
    }

    .price-final .label {
        font-size: 16px;
        font-weight: 700;
        color: #222;
    }

    .price-final .amount {
        font-size: 20px;
        font-weight: 800;
        color: #16a34a;
    }


    .payment-method {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
    }

    .payment-method .label {
        color: #717171;
    }

    .payment-method .value {
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        color: #222;
    }


    .receipt-footer {
        background: #f8f8f8;
        border-top: 1px solid #ddd;
        padding: 20px 32px;
        text-align: center;
        font-size: 12px;
        color: #9ca3af;
    }


    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 28px;
        flex-wrap: wrap;
    }

    .btn-print {
        padding: 14px 28px;
        background: #1e3a8a;
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-print:hover {
        background: #1e40af;
    }

    .btn-outline-action {
        padding: 14px 28px;
        background: #fff;
        color: #374151;
        border: 1.5px solid #ddd;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
    }

    .btn-outline-action:hover {
        border-color: #999;
    }
</style>
@endpush

@section('content')

<div style="max-width:680px; margin:0 auto;">

    <!-- Success Banner -->
    <div class="success-banner no-print">
        <div class="success-icon">
            <svg width="36" height="36" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1>Payment Successful!</h1>
        <p>Your booking is confirmed. Here is your receipt.</p>
    </div>

    <!-- Receipt Card -->
    <div class="receipt-card">

        <!-- Header -->
        <div class="receipt-header">
            <div class="hotel-name">LaraHotel</div>
            <div class="receipt-label">Payment Receipt</div>
            <div class="receipt-ref">{{ $booking->reference }}</div>
        </div>

        <div class="receipt-body">

            <!-- Guest Info -->
            <div class="section-label">Guest Information</div>
            <div class="guest-grid">
                <div>
                    <div class="label">Name</div>
                    <div class="value">{{ $booking->user->name }}</div>
                </div>
                <div>
                    <div class="label">Email</div>
                    <div class="value">{{ $booking->user->email }}</div>
                </div>
            </div>

            <hr class="divider">

            <!-- Room Info -->
            <div class="section-label">Room Details</div>
            <div class="room-info-box">
                <div class="room-name">{{ $booking->room->roomType->name }}</div>
                <div class="room-sub">Room {{ $booking->room->room_number }} - Floor {{ $booking->room->floor }} - {{ $booking->room->roomType->bed_type ?: 'Standard Bed' }}</div>
                <div class="room-dates-grid">
                    <div>
                        <div class="date-label">Check-in</div>
                        <div class="date-value">{{ $booking->check_in->format('D, M d Y') }}</div>
                    </div>
                    <div>
                        <div class="date-label">Check-out</div>
                        <div class="date-value">{{ $booking->check_out->format('D, M d Y') }}</div>
                    </div>
                    <div>
                        <div class="date-label">Guests</div>
                        <div class="date-value">{{ $booking->guests }} Adult{{ $booking->guests > 1 ? 's' : '' }}</div>
                    </div>
                </div>
            </div>

            <hr class="divider">

            <!-- Price Breakdown -->
            @php
                $subtotal = $booking->room->roomType->price_per_night * $booking->nights;
                $taxes    = round($subtotal * 0.10, 2);
            @endphp

            <div class="section-label">Price Breakdown</div>
            <div class="price-row">
                <span>${{ number_format($booking->room->roomType->price_per_night, 0) }} × {{ $booking->nights }} night{{ $booking->nights > 1 ? 's' : '' }}</span>
                <span>${{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="price-row border-top">
                <span>Taxes (10%)</span>
                <span>${{ number_format($taxes, 2) }}</span>
            </div>
            <div class="price-final">
                <span class="label">Total Paid</span>
                <span class="amount">${{ number_format($booking->total_price, 2) }}</span>
            </div>

            <hr class="divider">

            <!-- Payment Method -->
            <div class="payment-method">
                <span class="label">Payment Method</span>
                <span class="value">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="1" y="4" width="22" height="16" rx="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    Online Card Payment
                </span>
            </div>
        </div>

        <!-- Footer -->
        <div class="receipt-footer">
            Thank you for choosing LaraHotel. We look forward to welcoming you!<br>
            For assistance, please contact our front desk. Reference: <strong>{{ $booking->reference }}</strong>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons no-print">
        <button onclick="window.print()" class="btn-print">Print Receipt</button>
        <a href="{{ route('bookings.my') }}" class="btn-outline-action">View My Bookings</a>
        <a href="{{ route('home') }}" class="btn-outline-action">Back to Home</a>
    </div>

</div>

@endsection
