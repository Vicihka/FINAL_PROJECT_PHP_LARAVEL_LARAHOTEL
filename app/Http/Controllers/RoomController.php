<?php

namespace App\Http\Controllers;

use App\Models\RoomCategory;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $categories = RoomCategory::orderBy('name')->get();

        $roomTypes = RoomType::withCount('rooms')
            ->with(['availableRooms', 'roomCategory'])
            ->when($category, fn($q) => $q->whereHas('roomCategory', fn($categoryQuery) => $categoryQuery->where('name', $category)))
            ->get();

        return view('rooms.index', compact('roomTypes', 'category', 'categories'));
    }

    public function show(RoomType $roomType)
    {
        $roomType->load('rooms', 'roomCategory');

        return view('rooms.show', compact('roomType'));
    }
}
