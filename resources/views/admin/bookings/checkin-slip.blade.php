<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-in Slip - {{ $booking->reference }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .slip-card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
        }
        @page { size: A5; margin: 12mm; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 p-6">


    <div class="no-print mb-6 flex items-center justify-between">
        <a href="{{ route('admin.bookings.index') }}"
            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
            Back to Bookings
        </a>
        <div class="flex gap-3">
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9V3h12v6m1 5H5a2 2 0 0 0-2 2v5h4v-3h10v3h4v-5a2 2 0 0 0-2-2z"/></svg>
                Print Slip
            </button>
        </div>
    </div>


    <div class="slip-card mx-auto max-w-lg overflow-hidden rounded-3xl bg-white shadow-2xl">


        <div class="bg-gradient-to-br from-slate-900 to-indigo-900 px-8 py-7 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xl font-bold tracking-wide">LaraHotel</div>
                    <div class="mt-1 text-xs font-medium uppercase tracking-[0.15em] text-indigo-300">Check-in Slip</div>
                </div>
                <div class="text-right">
                    <div class="text-xs text-indigo-300">Reference</div>
                    <div class="mt-1 font-mono text-sm font-bold">{{ $booking->reference }}</div>
                </div>
            </div>
        </div>


        <div class="border-b border-emerald-100 bg-emerald-50 px-8 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <div class="text-sm font-bold text-emerald-800">Welcome, {{ $booking->user->name }}!</div>
                    <div class="text-xs text-emerald-600">We're delighted to have you at LaraHotel.</div>
                </div>
            </div>
        </div>

        <div class="px-8 py-6 space-y-5">


            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400 mb-2">Your Room</div>
                <div class="text-lg font-bold text-slate-900">{{ $booking->room->roomType->name }}</div>
                <div class="mt-1 text-sm text-slate-500">
                    Room <strong class="text-slate-800">{{ $booking->room->room_number }}</strong>
                    - Floor <strong class="text-slate-800">{{ $booking->room->floor }}</strong>
                    - {{ $booking->room->roomType->bed_type ?: 'Standard Bed' }}
                </div>
            </div>


            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-2xl border border-slate-200 p-4 text-center">
                    <div class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">Check-in</div>
                    <div class="mt-2 text-base font-bold text-slate-900">{{ $booking->check_in->format('M d, Y') }}</div>
                    <div class="mt-1 text-xs text-slate-500">{{ $booking->check_in->format('l') }}</div>
                    <div class="mt-2 text-xs text-indigo-600 font-semibold">After 3:00 PM</div>
                </div>
                <div class="rounded-2xl border border-slate-200 p-4 text-center">
                    <div class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-400">Check-out</div>
                    <div class="mt-2 text-base font-bold text-slate-900">{{ $booking->check_out->format('M d, Y') }}</div>
                    <div class="mt-1 text-xs text-slate-500">{{ $booking->check_out->format('l') }}</div>
                    <div class="mt-2 text-xs text-indigo-600 font-semibold">Before 11:00 AM</div>
                </div>
            </div>


            <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3 text-sm">
                <div class="text-slate-600">Duration</div>
                <div class="font-bold text-slate-900">{{ $booking->nights }} Night{{ $booking->nights > 1 ? 's' : '' }}</div>
            </div>
            <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3 text-sm">
                <div class="text-slate-600">Guests</div>
                <div class="font-bold text-slate-900">{{ $booking->guests }} Adult{{ $booking->guests > 1 ? 's' : '' }}</div>
            </div>

            <div class="border-t border-dashed border-slate-200 pt-4">

                <div class="flex items-center justify-between">
                    <div class="text-sm text-slate-600">Payment Status</div>
                    @if($booking->payment_status === 'paid')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            PAID
                        </span>
                    @else
                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">UNPAID</span>
                    @endif
                </div>
                <div class="mt-3 flex items-center justify-between">
                    <div class="text-sm text-slate-600">Total Amount</div>
                    <div class="text-xl font-extrabold text-slate-900">${{ number_format($booking->total_price, 2) }}</div>
                </div>
            </div>
        </div>


        <div class="border-t border-slate-100 bg-slate-50 px-8 py-5">
            <div class="text-center text-xs text-slate-400">
                Please keep this slip for your records.<br>
                For assistance, contact our front desk anytime.
            </div>
            <div class="mt-3 flex items-center justify-center gap-2 text-xs text-slate-400">
                <span>Issued: {{ now()->format('M d, Y h:i A') }}</span>
                <span>-</span>
                <span>LaraHotel Front Desk</span>
            </div>
        </div>

    </div>

</body>
</html>
