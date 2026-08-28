<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Verify Guest') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                <div class="p-6 pl-7 text-center">
                    <x-flash-messages class="mb-4 px-4 py-3 text-sm" />

                    <p class="text-sm text-slate-500">{{ __('Entry code') }}</p>
                    <h3 class="text-lg font-semibold tracking-widest text-slate-900">{{ $contributor->text_code }}</h3>

                    <h1 class="mt-4 text-2xl font-semibold text-slate-900">{{ $contributor->name }}</h1>
                    <p class="mt-1 text-sm text-slate-500">{{ $contributor->phone_no }}</p>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ __('Seats reserved') }}: <span class="font-medium text-slate-900">{{ $contributor->assigned_seats }}</span>
                    </p>

                    @php
                        $statusStyles = [
                            'not_invited' => 'bg-slate-100 text-slate-600',
                            'invited' => 'bg-amber-50 text-amber-700',
                            'attended' => 'bg-emerald-50 text-emerald-700',
                            'not_attended' => 'bg-rose-50 text-rose-700',
                        ];
                    @endphp
                    <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $statusStyles[$contributor->status] ?? 'bg-slate-100 text-slate-600' }}">
                        {{ ucfirst(str_replace('_', ' ', $contributor->status)) }}
                    </span>

                    <div class="mt-6">
                        @if ($contributor->status === 'attended')
                            <p class="text-sm font-medium text-emerald-700">{{ __('Already checked in.') }}</p>
                        @else
                            <form method="POST" action="{{ route('invitations.confirm', $contributor->text_code) }}">
                                @csrf
                                <x-primary-button class="w-full justify-center">
                                    {{ __('Confirm Attendance') }}
                                </x-primary-button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
