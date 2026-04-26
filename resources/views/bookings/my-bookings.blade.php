@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<style>

    .bookings-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .bookings-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #222;
    }

    .bookings-header p {
        font-size: 14px;
        color: #717171;
        margin-top: 6px;
    }


    .table-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .bookings-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 860px;
    }


    .bookings-table thead tr {
        background: #f8f8f8;
    }

    .bookings-table th {
        text-align: left;
        padding: 14px 16px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #717171;
        font-weight: 600;
    }


    .bookings-table td {
        padding: 18px 16px;
        border-top: 1px solid #ddd;
    }

    .room-number {
        font-weight: 600;
        color: #222;
    }

    .room-type {
        font-size: 13px;
        color: #717171;
        margin-top: 4px;
    }

    .date-range {
        color: #222;
    }

    .date-nights {
        font-size: 13px;
        color: #717171;
        margin-top: 4px;
    }

    .total-price {
        font-weight: 600;
        color: #222;
    }


    .badge {
        display: inline-flex;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-warning { background: #fef3c7; color: #92400e; }
    .badge-success { background: #dcfce7; color: #166534; }
    .badge-danger  { background: #fee2e2; color: #991b1b; }
    .badge-default { background: #e2e8f0; color: #1e293b; }


    .btn-pay {
        display: inline-block;
        padding: 8px 16px;
        background: #1a56db;
        color: #fff;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-pay:hover {
        background: #1648c0;
    }

    .btn-receipt {
        display: inline-block;
        padding: 8px 16px;
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #86efac;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-receipt:hover {
        background: #dcfce7;
    }


    .empty-row td {
        text-align: center;
        padding: 48px 16px;
        color: #717171;
    }
</style>

<div class="page-hero">
    <h1>My Bookings</h1>
    <p>Track your reservations, payment status, and booking updates in one place.</p>
</div>

<div class="table-card">
    <div class="bookings-header">
        <div>
            <h2>Reservation History</h2>
            <p>{{ $bookings->count() }} booking{{ $bookings->count() === 1 ? '' : 's' }} found.</p>
        </div>
        <a href="{{ route('rooms.index') }}" class="btn-outline">Book Another Room</a>
    </div>

    <div class="table-wrapper">
        <table class="bookings-table">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Dates</th>
                    <th>Guests</th>
                    <th>Booking</th>
                    <th>Payment</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    @php
                        $bookingBadge = [
                            'pending_payment' => 'badge-warning',
                            'confirmed'       => 'badge-success',
                            'pending'         => 'badge-warning',
                            'cancelled'       => 'badge-danger',
                        ];
                        $bookingLabel = [
                            'pending_payment' => 'Awaiting Payment',
                            'confirmed'       => 'Confirmed',
                            'pending'         => 'Pending',
                            'cancelled'       => 'Cancelled',
                        ];
                        $paymentClass = $booking->payment_status === 'paid' ? 'badge-success' : 'badge-danger';
                    @endphp
                    <tr>
                        <td>
                            <div class="room-number">Room {{ $booking->room->room_number }}</div>
                            <div class="room-type">{{ $booking->room->roomType->name }} - {{ $booking->room->roomType->bed_type ?: 'Standard Bed' }}</div>
                        </td>
                        <td>
                            <div class="date-range">{{ $booking->check_in->format('M d, Y') }} to {{ $booking->check_out->format('M d, Y') }}</div>
                            <div class="date-nights">{{ $booking->nights }} night{{ $booking->nights === 1 ? '' : 's' }}</div>
                        </td>
                        <td>{{ $booking->guests }}</td>
                        <td>
                            <span class="badge {{ $bookingBadge[$booking->status] ?? 'badge-default' }}">
                                {{ $bookingLabel[$booking->status] ?? ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $paymentClass }}">
                                {{ $booking->payment_status === 'paid' ? 'Paid' : 'Unpaid' }}
                            </span>
                        </td>
                        <td class="total-price">${{ number_format($booking->total_price, 2) }}</td>
                        <td>
                            @if($booking->status === 'pending_payment')
                                <a href="{{ route('payment.show', $booking) }}" class="btn-pay">Pay Now</a>
                            @elseif($booking->status === 'confirmed' && $booking->payment_status === 'paid')
                                <a href="{{ route('payment.success', $booking) }}" class="btn-receipt">View Receipt</a>
                            @else
                                <span style="font-size:13px; color:#9ca3af;">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="7">You have no bookings yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
