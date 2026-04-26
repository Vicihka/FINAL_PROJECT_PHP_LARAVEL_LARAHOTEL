<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Notifications\Notification;

class BookingStatusChanged extends Notification
{
    public function __construct(public Booking $booking, public string $type) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $room     = $this->booking->room->room_number;
        $roomType = $this->booking->room->roomType->name;

        $messages = [
            'paid'      => "Payment confirmed! Your booking for Room {$room} ({$roomType}) is now confirmed.",
            'cancelled' => "Your booking for Room {$room} ({$roomType}) has been cancelled by the hotel.",
        ];

        return [
            'booking_id'  => $this->booking->id,
            'type'        => $this->type,
            'message'     => $messages[$this->type] ?? 'Your booking status has been updated.',
            'room_number' => $room,
            'room_type'   => $roomType,
            'check_in'    => $this->booking->check_in->format('M d, Y'),
            'check_out'   => $this->booking->check_out->format('M d, Y'),
        ];
    }
}
