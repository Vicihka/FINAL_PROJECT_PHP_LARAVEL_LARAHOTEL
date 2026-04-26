<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - LaraHotel</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top,_#eef4ff,_#f8fafc_48%,_#f8fafc)] text-slate-900">
    @php
        $user = auth()->user();
        $initials = collect(explode(' ', $user->name))
            ->filter()
            ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
            ->take(2)
            ->implode('');

        $navigation = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard'],
            ['label' => 'Bookings', 'route' => 'admin.bookings.index', 'match' => 'admin.bookings.*'],
            ['label' => 'Categories', 'route' => 'admin.room-categories.index', 'match' => 'admin.room-categories.*'],
            ['label' => 'Room Types', 'route' => 'admin.room-types.index', 'match' => 'admin.room-types.*'],
            ['label' => 'Rooms', 'route' => 'admin.rooms.index', 'match' => 'admin.rooms.*'],
            ['label' => 'Guests', 'route' => 'admin.guests.index', 'match' => 'admin.guests.*'],
            ['label' => 'Messages', 'route' => 'admin.messages.index', 'match' => 'admin.messages.*'],
        ];
    @endphp

    <div class="flex min-h-screen">
        <aside class="hidden w-72 shrink-0 border-r border-slate-200/80 bg-white/95 xl:flex xl:flex-col">
            <div class="border-b border-slate-200 px-8 py-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-sky-500 text-sm font-bold text-white shadow-lg shadow-indigo-200">LH</div>
                    <div>
                        <div class="text-lg font-semibold text-slate-900">LaraHotel</div>
                        <div class="text-sm text-slate-500">Admin Workspace</div>
                    </div>
                </a>
            </div>

            <nav class="flex-1 space-y-2 px-5 py-6">
                @foreach($navigation as $item)
                    @php $active = request()->routeIs($item['match']); @endphp
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ $active ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $active ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500' }}">
                            @switch($item['label'])
                                @case('Dashboard')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75h7.5v7.5h-7.5zm9 0h7.5v4.5h-7.5zm0 6h7.5v10.5h-7.5zm-9 9h7.5v1.5h-7.5z" /></svg>
                                    @break
                                @case('Bookings')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z"/></svg>
                                    @break
                                @case('Categories')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 6h9m-9 6h9m-9 6h5.25M5.25 3.75h13.5A2.25 2.25 0 0 1 21 6v12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18V6a2.25 2.25 0 0 1 2.25-2.25Z" /></svg>
                                    @break
                                @case('Room Types')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h16.5M6 7.5V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v1.5m-12 0v10.5A2.25 2.25 0 0 0 8.25 20.25h7.5A2.25 2.25 0 0 0 18 18V7.5" /></svg>
                                    @break
                                @case('Rooms')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21V9l9-6 9 6v12m-4.5 0v-6h-9v6"/></svg>
                                    @break
                                @case('Guests')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 20a6 6 0 0 0-12 0m9-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 8a4 4 0 0 0-4-4m0-8a3 3 0 1 1 0 6"/></svg>
                                    @break
                                @default
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 7.5v9A2.25 2.25 0 0 1 19.5 18.75H4.5A2.25 2.25 0 0 1 2.25 16.5v-9m19.5 0A2.25 2.25 0 0 0 19.5 5.25H4.5A2.25 2.25 0 0 0 2.25 7.5m19.5 0-8.69 5.79a1.5 1.5 0 0 1-1.62 0L2.25 7.5"/></svg>
                            @endswitch
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto border-t border-slate-200 p-5">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-slate-900">Need a quick overview?</p>
                    <p class="mt-2 text-sm text-slate-500">Use the dashboard to track bookings, guests, room availability, and messages at a glance.</p>
                    <form action="{{ route('logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex min-h-screen flex-1 flex-col">
            <header class="border-b border-slate-200 bg-white/80 backdrop-blur">
                <div class="flex flex-col gap-5 px-6 py-5 md:px-8 lg:px-10 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                            <span>Admin</span>
                            <span>/</span>
                            <span class="font-medium text-slate-700">@yield('page-title', 'Dashboard')</span>
                        </div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-950">@yield('page-title', 'Dashboard')</h1>
                        <p class="mt-1 text-sm text-slate-500">@yield('page-subtitle', 'Manage hotel operations from one clean workspace.')</p>
                    </div>

                    <div class="flex flex-col gap-4 md:flex-row md:items-center">
                        <form action="@yield('search-route', url()->current())" method="GET" class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm">
                            @yield('search-hidden')
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.4a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                            <input name="search" type="text" placeholder="Search..." value="{{ request('search') }}" class="w-full min-w-0 border-0 bg-transparent text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none md:w-64">
                        </form>

                        <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-600 text-sm font-bold text-white">{{ $initials }}</div>
                            <div>
                                <div class="text-sm font-semibold text-slate-900">{{ $user->name }}</div>
                                <div class="text-xs uppercase tracking-[0.16em] text-slate-500">Administrator</div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-6 py-6 md:px-8 lg:px-10">
                @if(session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700 shadow-sm">
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
