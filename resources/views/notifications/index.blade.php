@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<style>

    .notifications-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        max-width: 760px;
        margin: 0 auto;
    }

    .notifications-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .notifications-top h2 {
        font-size: 20px;
        font-weight: 700;
        color: #222;
    }

    .notifications-top span {
        font-size: 13px;
        color: #717171;
    }


    .notif-item {
        display: flex;
        gap: 16px;
        padding: 20px;
        border-radius: 14px;
        margin-bottom: 12px;
        border: 1px solid #ddd;
        background: #f8f8f8;
    }

    .notif-item.confirmed {
        border-color: #bbf7d0;
        background: #f0fdf4;
    }

    .notif-item.cancelled {
        border-color: #fecaca;
        background: #fff5f5;
    }


    .notif-icon {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #717171;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .notif-icon.confirmed { background: #16a34a; }
    .notif-icon.cancelled { background: #dc2626; }


    .notif-message {
        font-size: 14px;
        font-weight: 600;
        color: #222;
        margin-bottom: 4px;
    }

    .notif-meta {
        font-size: 12px;
        color: #717171;
    }


    .empty-state {
        text-align: center;
        padding: 48px 0;
        color: #717171;
    }

    .empty-state p:first-child {
        font-size: 15px;
    }

    .empty-state p:last-child {
        font-size: 13px;
        margin-top: 8px;
    }
</style>

<div class="page-hero">
    <h1>Notifications</h1>
    <p>Stay updated on your booking confirmations and hotel announcements.</p>
</div>

<div class="notifications-card">

    <div class="notifications-top">
        <h2>All Notifications</h2>
        <span>{{ $notifications->count() }} total</span>
    </div>

    @forelse($notifications as $notification)
        @php
            $type        = $notification->data['type'] ?? '';
            $isConfirmed = $type === 'paid';
            $isCancelled = $type === 'cancelled';
            $itemClass   = $isConfirmed ? 'confirmed' : ($isCancelled ? 'cancelled' : '');
        @endphp

        <div class="notif-item {{ $itemClass }}">

            <!-- Icon -->
            <div class="notif-icon {{ $itemClass }}">
                @if($isConfirmed)
                    <svg width="20" height="20" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                @elseif($isCancelled)
                    <svg width="20" height="20" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                @else
                    <svg width="20" height="20" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                    </svg>
                @endif
            </div>

            <!-- Text -->
            <div>
                <div class="notif-message">
                    {{ $notification->data['message'] ?? 'Booking update' }}
                </div>
                <div class="notif-meta">
                    {{ $notification->created_at->diffForHumans() }}
                    @if(isset($notification->data['check_in']))
                        - {{ $notification->data['check_in'] }} to {{ $notification->data['check_out'] }}
                    @endif
                </div>
            </div>

        </div>
    @empty
        <div class="empty-state">
            <p>No notifications yet.</p>
            <p>You'll be notified here when your booking is confirmed or updated.</p>
        </div>
    @endforelse

</div>

@endsection
