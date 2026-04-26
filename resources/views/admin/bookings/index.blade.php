@extends('layouts.admin')

@section('title', 'Bookings')
@section('page-title', 'Bookings')
@section('page-subtitle', 'Manage all guest reservations.')
@section('search-route', route('admin.bookings.index'))
@section('search-hidden')
    @if($status)
        <input type="hidden" name="status" value="{{ $status }}">
    @endif
@endsection

@section('content')
    @php
        $tabs = [
            ['label' => 'All',              'value' => null],
            ['label' => 'Awaiting Payment', 'value' => 'pending_payment'],
            ['label' => 'Confirmed',        'value' => 'confirmed'],
            ['label' => 'Cancelled',        'value' => 'cancelled'],
        ];
        $statusClasses = [
            'confirmed' => 'bg-emerald-100 text-emerald-700',
            'pending' => 'bg-amber-100 text-amber-700',
            'cancelled' => 'bg-rose-100 text-rose-700',
        ];
    @endphp

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-amber-600">Awaiting Payment</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $bookings->where('status', 'pending_payment')->count() }}</div>
                <div class="mt-1 text-sm text-slate-500">Bookings waiting for guest payment</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Confirmed in View</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $bookings->where('status', 'confirmed')->count() }}</div>
                <div class="mt-1 text-sm text-slate-500">Reservations paid and approved</div>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Cancelled in View</div>
                <div class="mt-3 text-3xl font-bold text-slate-950">{{ $bookings->where('status', 'cancelled')->count() }}</div>
                <div class="mt-1 text-sm text-slate-500">Reservations no longer active</div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-200 pb-5 md:flex-row md:items-center md:justify-between">
            <div class="flex flex-wrap gap-2">
                @foreach($tabs as $tab)
                    @php
                        $active = $status === $tab['value'] || ($tab['value'] === null && !$status);
                        $params = array_filter(['status' => $tab['value'], 'search' => request('search')]);
                    @endphp
                    <a href="{{ route('admin.bookings.index', $params) }}"
                        class="inline-flex rounded-full px-4 py-2 text-sm font-semibold transition {{ $active ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $tab['label'] }}
                    </a>
                @endforeach
            </div>
            <div class="text-sm text-slate-500">{{ $bookings->count() }} booking{{ $bookings->count() === 1 ? '' : 's' }}</div>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-[0.16em] text-slate-500">
                        <th class="px-4 py-3">Guest</th>
                        <th class="px-4 py-3">Room</th>
                        <th class="px-4 py-3">Stay Dates</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Booking</th>
                        <th class="px-4 py-3">Payment</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <tr class="even:bg-slate-50/80">
                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-900">{{ $booking->user->name }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $booking->user->email }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-900">Room {{ $booking->room->room_number }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $booking->room->roomType->name }}</div>
                            </td>
                            <td class="px-4 py-4 text-slate-600">
                                <div>{{ $booking->check_in->format('M d, Y') }} - {{ $booking->check_out->format('M d, Y') }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $booking->nights }} night{{ $booking->nights === 1 ? '' : 's' }}</div>
                            </td>
                            <td class="px-4 py-4 font-semibold text-slate-900">${{ number_format($booking->total_price, 2) }}</td>
                            <td class="px-4 py-4">
                                @php
                                    $bookingLabel = [
                                        'pending_payment' => 'Awaiting Payment',
                                        'confirmed'       => 'Confirmed',
                                        'pending'         => 'Pending',
                                        'cancelled'       => 'Cancelled',
                                    ];
                                    $bookingClass = [
                                        'pending_payment' => 'bg-amber-100 text-amber-700',
                                        'confirmed'       => 'bg-emerald-100 text-emerald-700',
                                        'pending'         => 'bg-amber-100 text-amber-700',
                                        'cancelled'       => 'bg-rose-100 text-rose-700',
                                    ];
                                @endphp
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $bookingClass[$booking->status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $bookingLabel[$booking->status] ?? ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $booking->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $booking->payment_status === 'paid' ? 'Paid' : 'Unpaid' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @if(in_array($booking->status, ['pending', 'pending_payment']))
                                        <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-500">Confirm</button>
                                        </form>
                                    @endif
                                    @if($booking->status === 'confirmed')
                                        <a href="{{ route('admin.bookings.checkin-slip', $booking) }}" target="_blank"
                                            class="rounded-xl bg-indigo-50 px-3 py-2 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100">
                                            Check-in Slip
                                        </a>
                                    @endif
                                    @if($booking->status !== 'cancelled')
                                        <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="rounded-xl bg-rose-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-rose-500">Cancel</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-500">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
