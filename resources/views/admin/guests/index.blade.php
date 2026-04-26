@extends('layouts.admin')

@section('title', 'Guests')
@section('page-title', 'Guests')
@section('page-subtitle', 'View registered guests and their booking history.')
@section('search-route', route('admin.guests.index'))

@section('content')
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Guests in View</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $guests->count() }}</div>
                <div class="mt-1 text-sm text-slate-500">Registered guests shown in this directory</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Returning Guests</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $guests->where('bookings_count', '>', 0)->count() }}</div>
                <div class="mt-1 text-sm text-slate-500">Guests who already booked at least once</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Spend in View</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">${{ number_format($guests->sum('bookings_sum_total_price') ?? 0, 0) }}</div>
                <div class="mt-1 text-sm text-slate-500">Total spending from the guests listed below</div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <h2 class="text-lg font-semibold text-slate-950">Guest Directory</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $guests->count() }} guest{{ $guests->count() === 1 ? '' : 's' }} found.</p>
            </div>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-[0.16em] text-slate-500">
                        <th class="px-4 py-3">Guest</th>
                        <th class="px-4 py-3">Bookings</th>
                        <th class="px-4 py-3">Total Spent</th>
                        <th class="px-4 py-3">Joined</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($guests as $guest)
                        <tr class="even:bg-slate-50/80">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-100 font-semibold text-indigo-700">
                                        {{ strtoupper(substr($guest->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-900">{{ $guest->name }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ $guest->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-slate-600">{{ $guest->bookings_count }}</td>
                            <td class="px-4 py-4 font-semibold text-slate-900">${{ number_format($guest->bookings_sum_total_price ?? 0, 2) }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ $guest->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $guest->bookings_count > 0 ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $guest->bookings_count > 0 ? 'Returning guest' : 'New guest' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-slate-500">No guests registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
