<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'David Reception Invitation Management System') }}</title>

        <link rel="icon" type="image/svg+xml" href="/favicon.svg">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&family=figtree:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-100">

        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-950 via-slate-950 to-slate-950"></div>
            <div class="absolute -top-32 -right-32 h-96 w-96 rounded-full bg-amber-400/10 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-violet-700/20 blur-3xl"></div>

            <div class="relative">
                <!-- Header -->
                <header class="max-w-6xl mx-auto px-4 sm:px-6 py-6 flex items-center justify-between">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="flex items-center justify-center h-10 w-10 rounded-full bg-amber-400/10 ring-1 ring-amber-400/40 shrink-0">
                            <x-application-logo class="w-5 h-5 fill-current text-amber-400" />
                        </span>
                        <div class="leading-tight hidden sm:block">
                            <div class="font-semibold text-white">David Reception</div>
                            <div class="text-[11px] uppercase tracking-[0.2em] text-amber-400/80">Invitation Management</div>
                        </div>
                    </div>

                    <nav class="flex items-center gap-2 sm:gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-2 rounded-md bg-amber-400 text-slate-900 text-sm font-medium hover:bg-amber-300 transition">
                                Dashboard
                            </a>
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="inline-block px-4 py-2 rounded-md text-sm font-medium text-slate-200 hover:text-white transition">
                                    Log in
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-block px-5 py-2 rounded-md bg-amber-400 text-slate-900 text-sm font-medium hover:bg-amber-300 transition">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                </header>

                <!-- Hero -->
                <main class="max-w-6xl mx-auto px-4 sm:px-6 pt-16 pb-24 text-center">
                    <p class="text-amber-400/90 text-sm uppercase tracking-[0.3em] mb-4">You're Invited</p>
                    <h1 class="text-4xl sm:text-6xl font-semibold text-white leading-tight">
                        David Reception <br class="hidden sm:block"> Invitation Management System
                    </h1>
                    <p class="mt-6 max-w-2xl mx-auto text-slate-300 text-base sm:text-lg">
                        Manage guest lists, send SMS invitations, and verify RSVPs for David's reception —
                        all from one simple dashboard.
                    </p>

                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-block w-full sm:w-auto text-center px-6 py-3 rounded-md bg-amber-400 text-slate-900 font-medium hover:bg-amber-300 transition">
                                Go to Dashboard
                            </a>
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="inline-block w-full sm:w-auto text-center px-6 py-3 rounded-md border border-slate-600 text-slate-100 font-medium hover:border-amber-400 hover:text-amber-400 transition">
                                    Log in
                                </a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-block w-full sm:w-auto text-center px-6 py-3 rounded-md bg-amber-400 text-slate-900 font-medium hover:bg-amber-300 transition">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    </div>

                    <!-- Feature cards -->
                    <div class="mt-24 grid gap-6 sm:grid-cols-3 text-left">
                        <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-6">
                            <div class="h-10 w-10 rounded-lg bg-amber-400/10 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                            <h3 class="text-white font-medium">Guest List Management</h3>
                            <p class="mt-2 text-sm text-slate-400">Organize guests, track table assignments, and keep contact details in one place.</p>
                        </div>

                        <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-6">
                            <div class="h-10 w-10 rounded-lg bg-amber-400/10 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3.75h6.75m-9.303 3.376A9.859 9.859 0 013 12c0-5.03 4.03-9 9-9s9 3.97 9 9-4.03 9-9 9a9.86 9.86 0 01-4.126-.906l-3.51.94a.75.75 0 01-.913-.913l.94-3.51z" />
                                </svg>
                            </div>
                            <h3 class="text-white font-medium">SMS Invitations</h3>
                            <p class="mt-2 text-sm text-slate-400">Send personalized SMS invitations directly to every guest on the list.</p>
                        </div>

                        <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-6">
                            <div class="h-10 w-10 rounded-lg bg-amber-400/10 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-white font-medium">RSVP Verification</h3>
                            <p class="mt-2 text-sm text-slate-400">Verify invitations at the door and track attendance in real time.</p>
                        </div>
                    </div>
                </main>

                <footer class="max-w-6xl mx-auto px-6 py-8 text-center text-xs text-slate-500">
                    &copy; {{ date('Y') }} David Reception Invitation Management System
                </footer>
            </div>
        </div>
    </body>
</html>
