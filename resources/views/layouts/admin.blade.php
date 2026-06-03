@php
    $user = auth()->user();
    $initials = collect(explode(' ', $user->name))
        ->filter()
        ->map(fn (string $part) => strtoupper(substr($part, 0, 1)))
        ->take(2)
        ->join('');

    $navSections = [
        [
            'label' => 'Overview',
            'items' => [
                ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'match' => 'admin.dashboard'],
            ],
        ],
        [
            'label' => 'Coaching',
            'items' => [
                ['route' => 'admin.coaching-programs.index', 'label' => 'Coaching Programs', 'icon' => 'school', 'match' => 'admin.coaching-programs.*'],
                ['route' => 'admin.locations.index', 'label' => 'Locations', 'icon' => 'location_on', 'match' => 'admin.locations.*'],
                ['route' => 'admin.link-posts.index', 'label' => 'Life on the Links', 'icon' => 'photo_library', 'match' => 'admin.link-posts.*'],
            ],
        ],
        [
            'label' => 'Bookings',
            'items' => [
                ['route' => 'admin.calendar', 'label' => 'Calendar', 'icon' => 'calendar_month', 'match' => 'admin.calendar*'],
                ['route' => 'admin.appointments.index', 'label' => 'Appointments', 'icon' => 'event', 'match' => 'admin.appointments.*'],
            ],
        ],
        [
            'label' => 'System',
            'items' => [
                ['route' => 'admin.settings.edit', 'label' => 'Settings', 'icon' => 'settings', 'match' => 'admin.settings.*'],
                ['route' => 'admin.users.index', 'label' => 'Users', 'icon' => 'group', 'match' => 'admin.users.*'],
            ],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — Roshan Fernando Golf</title>
    <x-admin.material-icons-head />
    @vite(['resources/css/app.css', 'resources/js/admin.js'])
    @stack('admin-head')
</head>
<body class="min-h-screen bg-admin-canvas font-body text-[15px] text-slate-800 antialiased">
    <div id="admin-sidebar-overlay" class="fixed inset-0 z-40 hidden bg-slate-900/50 lg:hidden" aria-hidden="true"></div>

    <aside
        id="admin-sidebar"
        class="admin-sidebar fixed inset-y-0 left-0 z-50 flex h-svh w-[260px] -translate-x-full flex-col border-r border-slate-200 bg-admin-sidebar transition-[width,transform] duration-300 ease-out lg:translate-x-0"
    >
            <div class="flex shrink-0 items-center justify-between gap-2 border-b border-slate-100 px-4 py-4">
                <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-brand flex min-w-0 flex-1 items-center gap-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-primary text-on-primary shadow-admin-card">
                        <span class="material-symbols-outlined material-symbol text-[22px]">sports_golf</span>
                    </span>
                    <span class="admin-sidebar-brand-text truncate text-[15px] font-bold text-slate-900">Roshan Fernando</span>
                </a>
                <button type="button" data-sidebar-close class="rounded-admin-control p-1.5 text-slate-400 hover:bg-slate-100 lg:hidden" aria-label="Close menu">
                    <span class="material-symbols-outlined material-symbol text-xl">close</span>
                </button>
            </div>

            <nav class="admin-sidebar-nav min-h-0 flex-1 overflow-y-auto overscroll-contain px-3 py-4">
                @foreach ($navSections as $section)
                    <p class="admin-sidebar-section mb-2 px-3 text-[11px] font-semibold tracking-[0.08em] text-slate-400 uppercase">{{ $section['label'] }}</p>
                    <ul class="mb-4 space-y-0.5">
                        @foreach ($section['items'] as $item)
                            @php $active = request()->routeIs($item['match']); @endphp
                            <li>
                                <a
                                    href="{{ route($item['route']) }}"
                                    title="{{ $item['label'] }}"
                                    @class([
                                        'admin-sidebar-nav-item flex items-center gap-3 rounded-admin-control px-3 py-2 text-[14px] font-medium transition-colors',
                                        'bg-primary text-on-primary shadow-sm' => $active,
                                        'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! $active,
                                    ])
                                >
                                    <span @class([
                                        'material-symbols-outlined material-symbol shrink-0 text-[22px]',
                                        'text-on-primary' => $active,
                                        'text-slate-500' => ! $active,
                                    ])>{{ $item['icon'] }}</span>
                                    <span class="admin-sidebar-label truncate">{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </nav>

            <div class="admin-sidebar-footer shrink-0 border-t border-slate-100 p-3">
                <a href="{{ route('home') }}" target="_blank" class="admin-sidebar-footer-link admin-sidebar-label mb-2 flex items-center gap-2 rounded-admin-control px-3 py-2 text-[13px] text-slate-500 hover:bg-slate-50 hover:text-slate-800">
                    <span class="material-symbols-outlined material-symbol text-lg">open_in_new</span>
                    View website
                </a>
                <div class="admin-sidebar-user flex items-center gap-3 rounded-admin-surface bg-slate-50 px-3 py-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-primary text-sm font-bold text-on-primary">{{ $initials }}</span>
                    <div class="admin-sidebar-user-meta min-w-0 flex-1">
                        <p class="truncate text-[13px] font-semibold text-slate-900">{{ $user->name }}</p>
                        <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}" class="admin-sidebar-logout shrink-0">
                        @csrf
                        <button type="submit" class="rounded-admin-control p-1.5 text-slate-400 hover:bg-white hover:text-red-600" aria-label="Sign out">
                            <span class="material-symbols-outlined material-symbol text-xl">logout</span>
                        </button>
                    </form>
                </div>
            </div>
    </aside>

    <div class="admin-main-shell flex min-h-svh w-full min-w-0 flex-col">
            <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6 lg:px-8">
                <button
                    type="button"
                    data-sidebar-toggle
                    class="flex size-10 items-center justify-center rounded-admin-control border border-slate-200 bg-white text-slate-600 shadow-admin-card transition-colors hover:bg-slate-50"
                    aria-label="Toggle navigation"
                >
                    <span class="material-symbols-outlined material-symbol text-[22px]">menu</span>
                </button>

                <div class="relative">
                    <button
                        id="admin-user-menu-button"
                        type="button"
                        class="flex items-center gap-2 rounded-admin-control py-1.5 pr-2 pl-1.5 transition-colors hover:bg-slate-50"
                    >
                        <span class="flex size-9 items-center justify-center rounded-full bg-primary text-xs font-bold text-on-primary">{{ $initials }}</span>
                        <span class="hidden max-w-[140px] truncate text-sm font-medium text-slate-800 sm:block">{{ $user->name }}</span>
                        <span class="material-symbols-outlined material-symbol hidden text-[20px] text-slate-400 sm:block">expand_more</span>
                    </button>
                    <div id="admin-user-menu" class="absolute right-0 z-50 mt-2 hidden w-52 rounded-admin-surface border border-slate-200 bg-white py-1 shadow-admin-card-hover">
                        <div class="border-b border-slate-100 px-4 py-3 sm:hidden">
                            <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $user->email }}</p>
                        </div>
                        <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50">View website</a>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-left text-sm text-red-600 hover:bg-red-50">Sign out</button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                @yield('content')
            </main>
    </div>

    <x-admin.toasts />
</body>
</html>
