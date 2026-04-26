@extends('layouts.admin')

@section('title', 'Add Room Category')
@section('page-title', 'Add Room Category')
@section('page-subtitle', 'Create a main room group for your hotel building.')

@section('content')
    <div class="max-w-3xl rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('admin.room-categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Single Room" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                <p class="mt-2 text-sm text-slate-500">This is the group label shown in filters and room listings.</p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
                <textarea name="description" rows="4" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">{{ old('description') }}</textarea>
                <p class="mt-2 text-sm text-slate-500">Example: Ideal for solo travelers, compact comfort, best value.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-500">Save Category</button>
                <a href="{{ route('admin.room-categories.index') }}" class="inline-flex rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Cancel</a>
            </div>
        </form>
    </div>
@endsection
