@extends('layouts.admin')

@section('title', 'Edit Room Type')
@section('page-title', 'Edit Room Type')
@section('page-subtitle', 'Update the room type details guests will see and book.')

@section('content')
    <div class="max-w-4xl rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('admin.room-types.update', $roomType) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Room Type Name</label>
                <input type="text" name="name" value="{{ old('name', $roomType->name) }}" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                <p class="mt-2 text-sm text-slate-500">This is the bookable room type name shown to guests.</p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Category</label>
                <p class="mb-3 text-sm text-slate-500">This comes from your saved room categories.</p>
                <select name="room_category_id" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                    <option value="">Select category</option>
                    @foreach($categories as $categoryOption)
                        <option value="{{ $categoryOption->id }}" {{ (string) old('room_category_id', $roomType->room_category_id) === (string) $categoryOption->id ? 'selected' : '' }}>
                            {{ $categoryOption->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Bed Type</label>
                <input type="text" name="bed_type" value="{{ old('bed_type', $roomType->bed_type) }}" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
                <textarea name="description" rows="5" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">{{ old('description', $roomType->description) }}</textarea>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Price Per Night</label>
                    <input type="number" name="price_per_night" value="{{ old('price_per_night', $roomType->price_per_night) }}" min="1" step="0.01" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Max Guests</label>
                    <input type="number" name="max_guests" value="{{ old('max_guests', $roomType->max_guests) }}" min="1" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Size (Sq Ft)</label>
                    <input type="number" name="size_sqft" value="{{ old('size_sqft', $roomType->size_sqft) }}" min="1" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Rating</label>
                    <input type="number" name="rating" value="{{ old('rating', $roomType->rating) }}" min="1" max="5" step="0.1" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Room Image</label>
                @if($roomType->image_url)
                    <div class="mb-3">
                        <img src="{{ asset($roomType->image_url) }}" alt="{{ $roomType->name }}" class="h-32 w-48 rounded-2xl object-cover">
                        <p class="mt-1 text-xs text-slate-400">Current image - upload a new one to replace it.</p>
                    </div>
                @endif
                <input type="file" name="image_file" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="mt-2 text-sm text-slate-500">Leave empty to keep the current image.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-500">Update Room Type</button>
                <a href="{{ route('admin.room-types.index') }}" class="inline-flex rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Cancel</a>
            </div>
        </form>
    </div>
@endsection
