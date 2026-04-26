@extends('layouts.admin')

@section('title', 'Room Categories')
@section('page-title', 'Room Categories')
@section('page-subtitle', 'Create the main room groups for your single hotel building, like Single Room, Double Room, Twin Room, Family Room, or Suite.')
@section('search-route', route('admin.room-categories.index'))

@section('content')
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Categories</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $categories->count() }}</div>
                <div class="mt-1 text-sm text-slate-500">Saved room category groups</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Room Types Linked</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $categories->sum('room_types_count') }}</div>
                <div class="mt-1 text-sm text-slate-500">Room types currently assigned to categories</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Empty Categories</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $categories->where('room_types_count', 0)->count() }}</div>
                <div class="mt-1 text-sm text-slate-500">Categories ready to be used by room types</div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 border-b border-slate-200 pb-5 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-950">Category Library</h2>
                    <p class="mt-1 text-sm text-slate-500">Recommended for one hotel: Single Room, Double Room, Twin Room, Family Room, Suite.</p>
                </div>
                <a href="{{ route('admin.room-categories.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-500">Add Category</a>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.16em] text-slate-500">
                            <th class="px-4 py-3">Category</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3">Room Types</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($categories as $category)
                            <tr class="even:bg-slate-50/80">
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-slate-900">{{ $category->name }}</div>
                                </td>
                                <td class="px-4 py-4 text-slate-600">{{ $category->description ?: 'No description yet.' }}</td>
                                <td class="px-4 py-4 text-slate-600">{{ $category->room_types_count }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('admin.room-categories.edit', $category) }}" class="rounded-xl bg-indigo-50 px-3 py-2 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100">Edit</a>
                                        <form action="{{ route('admin.room-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete {{ $category->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-12 text-center text-slate-500">No categories created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
