<?php

namespace App\Http\Controllers;

use App\Models\RoomCategory;
use App\Models\RoomType;

class HomeController extends Controller
{
    public function index()
    {
        $featuredRooms = RoomType::withCount('rooms')
            ->with(['availableRooms', 'roomCategory'])
            ->take(6)
            ->get();

        $categories = RoomCategory::orderBy('name')->get();

        return view('home', compact('featuredRooms', 'categories'));
    }
}
