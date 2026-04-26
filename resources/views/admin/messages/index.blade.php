@extends('layouts.admin')

@section('title', 'Messages')
@section('page-title', 'Messages')
@section('page-subtitle', 'Read and track contact form messages from guests.')
@section('search-route', route('admin.messages.index'))

@section('content')
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <h2 class="text-lg font-semibold text-slate-950">Contact Inbox</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $messages->count() }} message{{ $messages->count() === 1 ? '' : 's' }} found.</p>
            </div>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-[0.16em] text-slate-500">
                        <th class="px-4 py-3">Sender</th>
                        <th class="px-4 py-3">Subject</th>
                        <th class="px-4 py-3">Message</th>
                        <th class="px-4 py-3">Received</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($messages as $message)
                        <tr class="align-top even:bg-slate-50/80">
                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-900">{{ $message->name }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $message->email }}</div>
                            </td>
                            <td class="px-4 py-4 font-medium text-slate-700">{{ $message->subject }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ $message->message }}</td>
                            <td class="px-4 py-4 text-slate-500">{{ $message->created_at->format('M d, Y g:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-slate-500">No messages yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
