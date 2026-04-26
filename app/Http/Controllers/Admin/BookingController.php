<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Notifications\BookingStatusChanged;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('search', ''));

        $bookings = Booking::with(['user', 'room.roomType'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($user) use ($search) {
                        $user->where('name', 'like', '%' . $search . '%');
                    })->orWhereHas('room', function ($room) use ($search) {
                        $room->where('room_number', 'like', '%' . $search . '%');
                    })->orWhereHas('room.roomType', function ($type) use ($search) {
                        $type->where('name', 'like', '%' . $search . '%');
                    });
                });
            })
            ->latest()
            ->get();

        return view('admin.bookings.index', compact('bookings', 'status', 'search'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,pending_payment,confirmed,cancelled',
        ]);

        $booking->load('room.roomType', 'user');

        $booking->update(['status' => $request->status]);

        if ($request->status === 'cancelled') {
            $booking->room()->update(['status' => 'available']);
            $booking->user->notify(new BookingStatusChanged($booking, 'cancelled'));
        }

        return back()->with('success', 'Booking status updated.');
    }

    public function checkinSlip(Booking $booking)
    {
        $booking->load('room.roomType', 'user');

        return view('admin.bookings.checkin-slip', compact('booking'));
    }
}
