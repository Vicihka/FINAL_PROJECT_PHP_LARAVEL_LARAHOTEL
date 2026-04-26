<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Notifications\BookingStatusChanged;

class PaymentController extends Controller
{
    public function show(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if($booking->status !== 'pending_payment', 404);

        $booking->load('room.roomType');

        return view('payment.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if($booking->status !== 'pending_payment', 403);

        $booking->load('room.roomType');

        $booking->update([
            'status'         => 'confirmed',
            'payment_status' => 'paid',
        ]);

        $booking->room->update(['status' => 'occupied']);

        $booking->user->notify(new BookingStatusChanged($booking, 'paid'));

        return redirect()->route('payment.success', $booking);
    }

    public function success(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if($booking->payment_status !== 'paid', 404);

        $booking->load('room.roomType', 'user');

        return view('payment.success', compact('booking'));
    }
}
