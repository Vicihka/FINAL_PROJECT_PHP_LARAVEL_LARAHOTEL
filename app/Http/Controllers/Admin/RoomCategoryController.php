<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomCategory;
use Illuminate\Http\Request;

class RoomCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $categories = RoomCategory::when($search !== '', function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->withCount('roomTypes')
            ->orderBy('name')
            ->get();

        return view('admin.room_categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('admin.room_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:room_categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        RoomCategory::create($validated);

        return redirect()->route('admin.room-categories.index')
            ->with('success', 'Room category "' . $validated['name'] . '" created successfully.');
    }

    public function edit(RoomCategory $roomCategory)
    {
        return view('admin.room_categories.edit', compact('roomCategory'));
    }

    public function update(Request $request, RoomCategory $roomCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:room_categories,name,' . $roomCategory->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $roomCategory->update($validated);
        $roomCategory->roomTypes()->update(['category' => $validated['name']]);

        return redirect()->route('admin.room-categories.index')
            ->with('success', 'Room category "' . $validated['name'] . '" updated successfully.');
    }

    public function destroy(RoomCategory $roomCategory)
    {
        if ($roomCategory->roomTypes()->exists()) {
            return redirect()->route('admin.room-categories.index')
                ->withErrors('You cannot delete a category that is still used by room types.');
        }

        $name = $roomCategory->name;
        $roomCategory->delete();

        return redirect()->route('admin.room-categories.index')
            ->with('success', 'Room category "' . $name . '" deleted.');
    }
}
