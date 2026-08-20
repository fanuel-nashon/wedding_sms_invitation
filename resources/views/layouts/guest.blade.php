<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'David Reception Invitation Management System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-violet-950 via-slate-950 to-slate-950">
            <div class="flex flex-col items-center">
                <a href="/" class="flex items-center justify-center h-16 w-16 rounded-full bg-amber-400/10 ring-1 ring-amber-400/40">
                    <x-application-logo class="w-8 h-8 fill-current text-amber-400" />
                </a>
                <div class="mt-4 text-center">
                    <div class="text-xl font-semibold tracking-wide text-white">David Reception</div>
                    <div class="text-xs uppercase tracking-[0.2em] text-amber-400/80">Invitation Management System</div>
                </div>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
