<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="lenis lenis-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Professional golf coaching in Perth tailored to your unique swing and goals. Experience precision instruction that delivers repeatable results.">

    <title>@yield('title', 'Roshan Fernando Golf | Elite Performance Coaching')</title>

    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0..1,0&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="min-h-screen bg-background font-body text-body-md text-on-surface antialiased selection:bg-primary-fixed-dim selection:text-primary"
    @if ($errors->any()) data-booking-open-on-load @endif
>
    @yield('content')
</body>
</html>
