<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function store(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'check_in'    => 'required|date|after_or_equal:today',
            'check_out'   => 'required|date|after:check_in',
            'guests'      => 'required|integer|min:1|max:' . $roomType->max_guests,
            'room_id'     => 'required|exists:rooms,id',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        if ($room->room_type_id !== $roomType->id) {
            throw ValidationException::withMessages([
                'room_id' => 'The selected room does not belong to this room type.',
            ]);
        }

        $hasConflict = Booking::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '<', $validated['check_out'])
            ->where('check_out', '>', $validated['check_in'])
            ->exists();

        if ($hasConflict) {
            throw ValidationException::withMessages([
                'room_id' => 'This room already has a booking for the selected dates. Please choose another room or different dates.',
            ]);
        }

        $nights   = \Carbon\Carbon::parse($validated['check_in'])->diffInDays($validated['check_out']);
        $subtotal = $roomType->price_per_night * $nights;
        $taxes    = round($subtotal * 0.10, 2);
        $total    = $subtotal + $taxes;

        $booking = Booking::create([
            'user_id'        => auth()->id(),
            'room_id'        => $room->id,
            'check_in'       => $validated['check_in'],
            'check_out'      => $validated['check_out'],
            'guests'         => $validated['guests'],
            'total_price'    => $total,
            'status'         => 'pending_payment',
            'payment_status' => 'unpaid',
        ]);

        return redirect()->route('payment.show', $booking);
    }
}
