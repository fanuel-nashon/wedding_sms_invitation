<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('Your Invitation') }} — {{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-10 bg-gradient-to-b from-violet-950 via-slate-950 to-slate-950">
            <div class="flex items-center justify-center h-14 w-14 rounded-full bg-amber-400/10 ring-1 ring-amber-400/40">
                <x-application-logo class="w-6 h-6 fill-current text-amber-400" />
            </div>
            <p class="mt-3 text-xs uppercase tracking-[0.2em] text-amber-400/80">{{ __('David Reception') }}</p>

            <div class="w-full sm:max-w-sm mt-6 bg-white rounded-2xl shadow-md overflow-hidden text-center px-6 py-8">
                <p class="text-sm text-slate-500">{{ __("You're Invited") }}</p>
                <h1 class="mt-1 text-2xl font-semibold text-slate-900">{{ $contributor->name }}</h1>
                <p class="mt-2 text-sm text-slate-500">
                    {{ __('Seats reserved') }}: <span class="font-medium text-slate-900">{{ $contributor->assigned_seats }}</span>
                </p>

                <div class="mt-6 flex items-center justify-center">
                    <div class="p-3 bg-white rounded-xl border border-slate-200">
                        {!! $contributor->qrCodeSvg() !!}
                    </div>
                </div>

                <p class="mt-4 text-xs text-slate-400">{{ __('Entry code') }}</p>
                <p class="text-lg font-semibold tracking-widest text-slate-900">{{ $contributor->text_code }}</p>

                <p class="mt-6 text-xs text-slate-400">
                    {{ __('Please show this QR code or entry code at the reception entrance.') }}
                </p>
            </div>
        </div>
    </body>
</html>
