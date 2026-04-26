<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Room;
use App\Models\RoomCategory;
use App\Models\RoomType;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue   = Booking::where('status', 'confirmed')->sum('total_price');
        $activeBookings = Booking::whereIn('status', ['pending', 'confirmed'])->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $totalGuests    = User::where('is_admin', false)->count();
        $contactMessages = ContactMessage::count();
        $roomCategories = RoomCategory::withCount('roomTypes')->orderBy('name')->get();

        $recentBookings = Booking::with(['user', 'room.roomType'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'activeBookings',
            'pendingBookings',
            'availableRooms',
            'totalGuests',
            'contactMessages',
            'recentBookings',
            'roomCategories'
        ));
    }
}
