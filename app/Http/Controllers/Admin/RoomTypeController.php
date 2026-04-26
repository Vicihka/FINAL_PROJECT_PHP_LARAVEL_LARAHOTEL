<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomCategory;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $categoryId = $request->query('category');

        $roomTypes = RoomType::when($search !== '', function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('category', 'like', '%' . $search . '%')
                        ->orWhereHas('roomCategory', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($categoryId, fn ($q) => $q->where('room_category_id', $categoryId))
            ->with('roomCategory')
            ->withCount('rooms')
            ->orderBy('name')
            ->get();

        $categories = RoomCategory::withCount('roomTypes')->orderBy('name')->get();

        return view('admin.room_types.index', compact('roomTypes', 'search', 'categoryId', 'categories'));
    }

    public function create()
    {
        $categories = RoomCategory::orderBy('name')->get();

        return view('admin.room_types.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'room_category_id'=> 'required|exists:room_categories,id',
            'bed_type'        => 'required|string|max:255',
            'description'     => 'required|string',
            'price_per_night' => 'required|numeric|min:1',
            'max_guests'      => 'required|integer|min:1',
            'size_sqft'       => 'required|integer|min:1',
            'rating'          => 'nullable|numeric|min:1|max:5',
            'image_file'      => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'room-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['image_url'] = 'images/' . $filename;
        }

        unset($validated['image_file']);
        $validated['category'] = RoomCategory::findOrFail($validated['room_category_id'])->name;

        RoomType::create($validated);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room type "' . $validated['name'] . '" created successfully.');
    }

    public function edit(RoomType $roomType)
    {
        $categories = RoomCategory::orderBy('name')->get();

        return view('admin.room_types.edit', compact('roomType', 'categories'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'room_category_id'=> 'required|exists:room_categories,id',
            'bed_type'        => 'required|string|max:255',
            'description'     => 'required|string',
            'price_per_night' => 'required|numeric|min:1',
            'max_guests'      => 'required|integer|min:1',
            'size_sqft'       => 'required|integer|min:1',
            'rating'          => 'nullable|numeric|min:1|max:5',
            'image_file'      => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'room-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['image_url'] = 'images/' . $filename;
        }

        unset($validated['image_file']);
        $validated['category'] = RoomCategory::findOrFail($validated['room_category_id'])->name;

        $roomType->update($validated);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room type "' . $roomType->name . '" updated successfully.');
    }

    public function destroy(RoomType $roomType)
    {
        $name = $roomType->name;
        $roomType->delete();

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room type "' . $name . '" deleted.');
    }
}
