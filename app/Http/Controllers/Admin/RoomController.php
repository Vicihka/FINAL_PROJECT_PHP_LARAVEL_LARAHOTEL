<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $rooms = Room::with('roomType')
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('room_number', 'like', '%' . $search . '%')
                        ->orWhere('floor', 'like', '%' . $search . '%')
                        ->orWhereHas('roomType', function ($type) use ($search) {
                            $type->where('name', 'like', '%' . $search . '%')
                                ->orWhere('category', 'like', '%' . $search . '%')
                                ->orWhereHas('roomCategory', function ($category) use ($search) {
                                    $category->where('name', 'like', '%' . $search . '%');
                                });
                        });
                });
            })
            ->orderBy('room_number')
            ->get();

        $roomTypes = RoomType::all();

        return view('admin.rooms.index', compact('rooms', 'roomTypes', 'search'));
    }

    public function create()
    {
        $roomTypes = RoomType::orderBy('name')->get();

        return view('admin.rooms.create', compact('roomTypes'));
    }

    public function bulkCreate()
    {
        $roomTypes = RoomType::orderBy('name')->get();

        return view('admin.rooms.bulk-create', compact('roomTypes'));
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'room_type_id'           => 'required|exists:room_types,id',
            'status'                 => 'required|in:available,occupied,maintenance,cleaning',
            'rooms'                  => 'required|array|min:1',
            'rooms.*.room_number'    => 'required|string|max:20',
            'rooms.*.floor'          => 'required|integer|min:1',
        ]);

        $submitted = collect($request->rooms);

        $duplicates = $submitted->pluck('room_number')->duplicates();
        if ($duplicates->isNotEmpty()) {
            return back()->withErrors(['rooms' => 'Duplicate room numbers in your list: ' . $duplicates->unique()->join(', ')])->withInput();
        }

        $existing = Room::whereIn('room_number', $submitted->pluck('room_number'))->pluck('room_number');
        if ($existing->isNotEmpty()) {
            return back()->withErrors(['rooms' => 'These room numbers already exist: ' . $existing->join(', ')])->withInput();
        }

        $now  = now();
        $rows = $submitted->map(fn($r) => [
            'room_type_id' => $request->room_type_id,
            'room_number'  => $r['room_number'],
            'floor'        => (int) $r['floor'],
            'status'       => $request->status,
            'created_at'   => $now,
            'updated_at'   => $now,
        ])->toArray();

        DB::transaction(fn() => Room::insert($rows));

        return redirect()->route('admin.rooms.index')
            ->with('success', count($rows) . ' rooms created successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number'  => 'required|string|max:20|unique:rooms,room_number',
            'floor'        => 'required|integer|min:1',
            'status'       => 'required|in:available,occupied,maintenance,cleaning',
        ]);

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room ' . $validated['room_number'] . ' added successfully.');
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::orderBy('name')->get();

        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number'  => 'required|string|max:20|unique:rooms,room_number,' . $room->id,
            'floor'        => 'required|integer|min:1',
            'status'       => 'required|in:available,occupied,maintenance,cleaning',
        ]);

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room ' . $room->room_number . ' updated successfully.');
    }

    public function destroy(Room $room)
    {
        $number = $room->room_number;
        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room ' . $number . ' deleted.');
    }

    public function updateStatus(Request $request, Room $room)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,maintenance,cleaning',
        ]);

        $room->update(['status' => $request->status]);

        return back()->with('success', 'Room ' . $room->room_number . ' status updated.');
    }
}
