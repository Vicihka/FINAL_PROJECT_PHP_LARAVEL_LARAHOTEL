@extends('layouts.admin')

@section('title', 'Rooms')
@section('page-title', 'Room Numbers')
@section('page-subtitle', 'Manage individual room numbers and live availability.')
@section('search-route', route('admin.rooms.index'))

@section('content')
    @php
        $statusClasses = [
            'available' => 'bg-emerald-100 text-emerald-700',
            'occupied' => 'bg-rose-100 text-rose-700',
            'maintenance' => 'bg-amber-100 text-amber-700',
            'cleaning' => 'bg-sky-100 text-sky-700',
        ];
    @endphp

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Available</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $rooms->where('status', 'available')->count() }}</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Occupied</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $rooms->where('status', 'occupied')->count() }}</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Maintenance</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $rooms->where('status', 'maintenance')->count() }}</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Cleaning</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $rooms->where('status', 'cleaning')->count() }}</div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-200 pb-5 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-950">Room Inventory</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $rooms->count() }} room{{ $rooms->count() === 1 ? '' : 's' }} listed.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.rooms.bulk-create') }}"
                    class="inline-flex items-center justify-center rounded-2xl border border-indigo-200 bg-indigo-50 px-4 py-2.5 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-100 {{ $roomTypes->count() === 0 ? 'pointer-events-none opacity-60' : '' }}">
                    Bulk Add Rooms
                </a>
                <a href="{{ route('admin.rooms.create') }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-500 {{ $roomTypes->count() === 0 ? 'pointer-events-none opacity-60' : '' }}">
                    Add Single Room
                </a>
            </div>
        </div>

        @if($roomTypes->count() === 0)
            <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                Add at least one room type before creating individual rooms.
            </div>
        @endif

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-[0.16em] text-slate-500">
                        <th class="px-4 py-3">Room</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Floor</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rooms as $room)
                        <tr class="even:bg-slate-50/80">
                            <td class="px-4 py-4 text-base font-semibold text-slate-900">{{ $room->room_number }}</td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-900">{{ $room->roomType->name }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $room->roomType->category }} - ${{ number_format($room->roomType->price_per_night, 0) }}/night</div>
                            </td>
                            <td class="px-4 py-4 text-slate-600">Floor {{ $room->floor }}</td>
                            <td class="px-4 py-4">
                                <form action="{{ route('admin.rooms.status', $room) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                                        <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="occupied" {{ $room->status === 'occupied' ? 'selected' : '' }}>Occupied</option>
                                        <option value="maintenance" {{ $room->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="cleaning" {{ $room->status === 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses[$room->status] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                    <a href="{{ route('admin.rooms.edit', $room) }}" class="rounded-xl bg-indigo-50 px-3 py-2 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100">Edit</a>
                                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Delete room {{ $room->room_number }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-slate-500">No rooms added yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
