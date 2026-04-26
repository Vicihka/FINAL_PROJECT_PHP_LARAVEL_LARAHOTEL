@extends('layouts.admin')

@section('title', 'Add Room Type')
@section('page-title', 'Add Room Type')
@section('page-subtitle', 'Create the actual room offer guests can book in your one-building hotel.')

@section('content')
    <div class="max-w-4xl rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('admin.room-types.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Room Type Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Standard Single Room" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                <p class="mt-2 text-sm text-slate-500">This is the actual product guests book, like `Standard Single Room`, `Deluxe Double Room`, or `Family Suite`.</p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Category</label>
                <p class="mb-3 text-sm text-slate-500">These categories come from the admin category list, so you can create your own now.</p>
                @if($categories->isEmpty())
                    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-700">
                        Create a room category first before adding a room type.
                        <a href="{{ route('admin.room-categories.create') }}" class="ml-2 font-semibold underline">Add category</a>
                    </div>
                @else
                    <select name="room_category_id" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                        <option value="">Select category</option>
                        @foreach($categories as $categoryOption)
                            <option value="{{ $categoryOption->id }}" {{ (string) old('room_category_id') === (string) $categoryOption->id ? 'selected' : '' }}>
                                {{ $categoryOption->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Bed Type</label>
                <input type="text" name="bed_type" value="{{ old('bed_type') }}" placeholder="1 Single Bed / 1 Double Bed / 2 Twin Beds" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                <p class="mt-2 text-sm text-slate-500">Describe the actual sleeping setup guests will get in this room type.</p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
                <textarea name="description" rows="5" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">{{ old('description') }}</textarea>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Price Per Night</label>
                    <input type="number" name="price_per_night" value="{{ old('price_per_night') }}" min="1" step="0.01" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Max Guests</label>
                    <input type="number" name="max_guests" value="{{ old('max_guests') }}" min="1" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Size (Sq Ft)</label>
                    <input type="number" name="size_sqft" value="{{ old('size_sqft') }}" min="1" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Rating</label>
                    <input type="number" name="rating" value="{{ old('rating', '5.0') }}" min="1" max="5" step="0.1" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Room Image</label>
                <input type="file" name="image_file" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="mt-2 text-sm text-slate-500">Upload JPG, PNG, or WEBP image for this room type.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-500 {{ $categories->isEmpty() ? 'pointer-events-none opacity-60' : '' }}">Save Room Type</button>
                <a href="{{ route('admin.room-types.index') }}" class="inline-flex rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Cancel</a>
            </div>
        </form>
    </div>
@endsection
