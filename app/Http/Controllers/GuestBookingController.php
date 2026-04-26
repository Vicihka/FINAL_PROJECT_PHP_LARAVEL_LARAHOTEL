<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class GuestBookingController extends Controller
{
    public function index()
    {
        if (auth()->user()?->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $bookings = Booking::with('room.roomType')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('bookings.my-bookings', compact('bookings'));
    }
}
