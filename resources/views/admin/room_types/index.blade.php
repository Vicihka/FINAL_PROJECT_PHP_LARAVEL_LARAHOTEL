@extends('layouts.admin')

@section('title', 'Room Types')
@section('page-title', 'Room Types')
@section('page-subtitle', 'Manage the actual room products guests book, like Standard Single, Deluxe Double, or Family Suite.')
@section('search-route', route('admin.room-types.index'))
@section('search-hidden')
    @if($categoryId)
        <input type="hidden" name="category" value="{{ $categoryId }}">
    @endif
@endsection

@section('content')
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-200 pb-5 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-950">Room Type Library</h2>
                <p class="mt-1 text-sm text-slate-500">Examples: Ocean View Suite, Deluxe King Room, Standard Queen Room.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.room-categories.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Manage Categories</a>
                <a href="{{ route('admin.room-types.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-500">Add Room Type</a>
            </div>
        </div>

        <div class="mt-5 grid gap-4 md:grid-cols-3">
            @foreach($categories as $categoryOption)
                @php $count = $roomTypes->where('room_category_id', $categoryOption->id)->count(); @endphp
                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                    <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ $categoryOption->name }}</div>
                    <div class="mt-2 text-2xl font-bold text-slate-950">{{ $count }}</div>
                    <div class="mt-1 text-sm text-slate-500">room type{{ $count === 1 ? '' : 's' }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 flex flex-wrap gap-2">
            <a href="{{ route('admin.room-types.index', array_filter(['search' => request('search')])) }}"
                class="inline-flex rounded-full px-4 py-2 text-sm font-semibold transition {{ !$categoryId ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                All Categories
            </a>
            @foreach($categories as $categoryOption)
                <a href="{{ route('admin.room-types.index', array_filter(['category' => $categoryOption->id, 'search' => request('search')])) }}"
                    class="inline-flex rounded-full px-4 py-2 text-sm font-semibold transition {{ (string) $categoryId === (string) $categoryOption->id ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $categoryOption->name }}
                </a>
            @endforeach
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-[0.16em] text-slate-500">
                        <th class="px-4 py-3">Room Type</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Bed Type</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Guests</th>
                        <th class="px-4 py-3">Size</th>
                        <th class="px-4 py-3">Rooms</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($roomTypes as $type)
                        <tr class="even:bg-slate-50/80">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-4">
                                    @if($type->image_url)
                                        <img src="{{ asset($type->image_url) }}" alt="{{ $type->name }}" class="h-14 w-14 rounded-2xl object-cover">
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600">RT</div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-slate-900">{{ $type->name }}</div>
                                        <div class="mt-1 text-xs text-slate-500">Rating {{ number_format($type->rating, 1) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4"><span class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">{{ $type->roomCategory?->name ?? $type->category }}</span></td>
                            <td class="px-4 py-4 text-slate-600">{{ $type->bed_type ?: 'Not set' }}</td>
                            <td class="px-4 py-4 font-semibold text-slate-900">${{ number_format($type->price_per_night, 0) }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ $type->max_guests }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ $type->size_sqft }} sq ft</td>
                            <td class="px-4 py-4 text-slate-600">{{ $type->rooms_count }}</td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.room-types.edit', $type) }}" class="rounded-xl bg-indigo-50 px-3 py-2 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100">Edit</a>
                                    <form action="{{ route('admin.room-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Delete {{ $type->name }}? This will also delete all rooms under it.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center text-slate-500">No room types found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
