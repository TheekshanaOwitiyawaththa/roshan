<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — Roshan Fernando Golf</title>
    <x-admin.material-icons-head />
    @vite(['resources/css/app.css'])
</head>
<body class="flex min-h-screen items-center justify-center bg-admin-canvas px-5 font-body text-slate-800">
    <div class="w-full max-w-md">
        <div class="mb-8 text-center">
            <span class="mx-auto mb-4 flex size-14 items-center justify-center rounded-full bg-primary text-on-primary shadow-admin-card">
                <span class="material-symbols-outlined material-symbol text-3xl">sports_golf</span>
            </span>
            <h1 class="text-xl font-bold text-slate-900">Roshan Fernando</h1>
            <p class="mt-2 text-sm text-slate-500">Sign in to your admin dashboard</p>
        </div>

        <div class="rounded-admin-surface border border-slate-200/90 bg-white p-8 shadow-admin-card">
            @if ($errors->any())
                <div class="mb-6 flex items-start gap-2 rounded-admin-control border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <span class="material-symbols-outlined material-symbol text-lg">error</span>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="admin-input">
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Password</label>
                    <input id="password" name="password" type="password" required class="admin-input">
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="rounded border-slate-300 text-primary focus:ring-primary/20">
                    Remember me
                </label>
                <button type="submit" class="w-full rounded-admin-control bg-primary py-3 text-sm font-semibold text-on-primary shadow-sm transition-colors hover:bg-primary-container">
                    Sign in to dashboard
                </button>
            </form>
        </div>
    </div>
</body>
</html>
