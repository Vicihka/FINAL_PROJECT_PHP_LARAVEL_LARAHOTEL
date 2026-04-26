@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', "Welcome back, " . auth()->user()->name . ". Here is today's hotel operations snapshot.")

@section('content')
    @php
        $cards = [
            [
                'label' => 'Confirmed Revenue',
                'value' => '$' . number_format($totalRevenue, 0),
                'note' => 'Revenue from confirmed bookings',
                'icon' => 'currency',
                'accent' => 'emerald',
            ],
            [
                'label' => 'Active Bookings',
                'value' => number_format($activeBookings),
                'note' => $pendingBookings . ' waiting for review',
                'icon' => 'calendar',
                'accent' => 'amber',
            ],
            [
                'label' => 'Available Rooms',
                'value' => number_format($availableRooms),
                'note' => 'Rooms ready for reservation',
                'icon' => 'rooms',
                'accent' => 'indigo',
            ],
            [
                'label' => 'Guest Messages',
                'value' => number_format($contactMessages),
                'note' => 'Contact enquiries in inbox',
                'icon' => 'mail',
                'accent' => 'sky',
            ],
        ];

        $accentMap = [
            'emerald' => ['soft' => 'bg-emerald-50 text-emerald-600', 'line' => 'border-emerald-100', 'pill' => 'bg-emerald-100 text-emerald-700'],
            'amber' => ['soft' => 'bg-amber-50 text-amber-600', 'line' => 'border-amber-100', 'pill' => 'bg-amber-100 text-amber-700'],
            'indigo' => ['soft' => 'bg-indigo-50 text-indigo-600', 'line' => 'border-indigo-100', 'pill' => 'bg-indigo-100 text-indigo-700'],
            'sky' => ['soft' => 'bg-sky-50 text-sky-600', 'line' => 'border-sky-100', 'pill' => 'bg-sky-100 text-sky-700'],
        ];

        $statusClasses = [
            'confirmed'       => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            'pending'         => 'bg-amber-100 text-amber-700 ring-amber-200',
            'pending_payment' => 'bg-amber-100 text-amber-700 ring-amber-200',
            'cancelled'       => 'bg-rose-100 text-rose-700 ring-rose-200',
        ];
        $statusLabels = [
            'confirmed'       => 'Confirmed',
            'pending'         => 'Pending',
            'pending_payment' => 'Awaiting Payment',
            'cancelled'       => 'Cancelled',
        ];

        $occupancyRate = $activeBookings > 0
            ? min(100, round(($activeBookings / max($availableRooms + $activeBookings, 1)) * 100))
            : 0;
    @endphp

    <div class="space-y-8">
        <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach($cards as $card)
                @php $tone = $accentMap[$card['accent']]; @endphp
                <article class="rounded-[26px] border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/50">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-sm font-medium text-slate-500">{{ $card['label'] }}</div>
                            <div class="mt-4 text-3xl font-bold tracking-tight text-slate-950">{{ $card['value'] }}</div>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl {{ $tone['soft'] }}">
                            @switch($card['icon'])
                                @case('currency')
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m3.75-9.75H10.5a2.25 2.25 0 1 0 0 4.5h3a2.25 2.25 0 1 1 0 4.5H8.25" /></svg>
                                    @break
                                @case('calendar')
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z"/></svg>
                                    @break
                                @case('rooms')
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21V9l9-6 9 6v12m-4.5 0v-6h-9v6"/></svg>
                                    @break
                                @default
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 7.5v9A2.25 2.25 0 0 1 19.5 18.75H4.5A2.25 2.25 0 0 1 2.25 16.5v-9m19.5 0-8.69 5.79a1.5 1.5 0 0 1-1.62 0L2.25 7.5"/></svg>
                            @endswitch
                        </div>
                    </div>

                    <div class="mt-5 border-t pt-4 {{ $tone['line'] }}">
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $tone['pill'] }}">
                            {{ $card['note'] }}
                        </span>
                    </div>
                </article>
            @endforeach
        </section>

        <section>
            <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/50">
                <div class="flex flex-col gap-4 border-b border-slate-200 pb-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-xl font-bold tracking-tight text-slate-950">Recent Bookings</h3>
                        <p class="mt-1 text-sm text-slate-500">Latest reservation activity from guests and room assignments.</p>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}"
                        class="inline-flex items-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                        View All Bookings
                    </a>
                </div>

                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead>
                            <tr class="text-left text-xs uppercase tracking-[0.16em] text-slate-500">
                                <th class="px-4 py-3">Guest</th>
                                <th class="px-4 py-3">Room</th>
                                <th class="px-4 py-3">Dates</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentBookings as $booking)
                                <tr class="odd:bg-white even:bg-slate-50/70">
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-slate-900">{{ $booking->user->name }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ $booking->user->email }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-slate-900">Room {{ $booking->room->room_number }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ $booking->room->roomType->name }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600">
                                        {{ $booking->check_in->format('M d') }} - {{ $booking->check_out->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusClasses[$booking->status] ?? 'bg-slate-100 text-slate-600 ring-slate-200' }}">
                                            {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 font-semibold text-slate-900">${{ number_format($booking->total_price, 0) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-12 text-center text-slate-500">No bookings yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
