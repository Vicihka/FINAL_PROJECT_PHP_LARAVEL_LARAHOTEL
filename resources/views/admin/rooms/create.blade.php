@extends('layouts.admin')

@section('title', 'Add Room')
@section('page-title', 'Add Room Number')
@section('page-subtitle', 'Create a new room under an existing room type.')

@section('content')
    <div class="max-w-3xl rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Room Type</label>
                <select name="room_type_id" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                    <option value="">Select a room type</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }} ({{ $type->category }} - ${{ number_format($type->price_per_night, 0) }}/night)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Room Number</label>
                    <input type="text" name="room_number" value="{{ old('room_number') }}" placeholder="101" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Floor</label>
                    <input type="number" name="floor" value="{{ old('floor', 1) }}" min="1" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
                <select name="status" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                    <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ old('status') === 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="cleaning" {{ old('status') === 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                </select>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-500">Add Room</button>
                <a href="{{ route('admin.rooms.index') }}" class="inline-flex rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Cancel</a>
            </div>
        </form>
    </div>
@endsection
