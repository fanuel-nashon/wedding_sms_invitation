<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    @php
        $statCards = [
            ['label' => 'Total Guests', 'value' => $stats['total'], 'icon' => 'users'],
            ['label' => 'Invited', 'value' => $stats['invited'], 'icon' => 'paper-airplane'],
            ['label' => 'Attended', 'value' => $stats['attended'], 'icon' => 'check-circle'],
            ['label' => 'Not Attended', 'value' => $stats['not_attended'], 'icon' => 'x-circle'],
            ['label' => 'Seats Reserved', 'value' => $stats['seats'], 'icon' => 'ticket'],
        ];
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Stat cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                @foreach ($statCards as $card)
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <span class="flex items-center justify-center h-9 w-9 rounded-lg bg-amber-50">
                            @switch($card['icon'])
                                @case('users')
                                    <svg class="w-4.5 h-4.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    @break
                                @case('paper-airplane')
                                    <svg class="w-4.5 h-4.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.769 59.769 0 0121.485 12 59.768 59.768 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                    @break
                                @case('check-circle')
                                    <svg class="w-4.5 h-4.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @break
                                @case('x-circle')
                                    <svg class="w-4.5 h-4.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @break
                                @case('ticket')
                                    <svg class="w-4.5 h-4.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                    </svg>
                                    @break
                            @endswitch
                        </span>
                        <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $card['value'] }}</p>
                        <p class="text-sm text-slate-500">{{ __($card['label']) }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Main content: activity feed + sidebar -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Recent activity -->
                <div class="lg:col-span-2 relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                    <div class="p-6 pl-7">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-slate-900">{{ __('Recent Activity') }}</h3>
                                <p class="mt-1 text-sm text-slate-500">{{ __('Latest actions taken across the system.') }}</p>
                            </div>
                            @role('superadmin')
                                <a href="{{ route('logs.index') }}" class="shrink-0 text-xs font-semibold uppercase tracking-widest text-amber-600 hover:text-amber-700">
                                    {{ __('View All') }}
                                </a>
                            @endrole
                        </div>

                        <ul class="mt-6 space-y-5">
                            @forelse ($recentActivity as $log)
                                <li class="flex gap-3">
                                    <span class="mt-1.5 h-2 w-2 rounded-full bg-amber-400 shrink-0"></span>
                                    <div class="min-w-0">
                                        <p class="text-sm text-slate-800">
                                            <span class="font-medium">{{ $log->user_name }}</span>
                                            {{ $log->action }}
                                        </p>
                                        <p class="text-xs text-slate-400">
                                            {{ $log->module }} &middot; {{ $log->action_time?->diffForHumans() }}
                                        </p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-sm text-slate-500">{{ __('No recent activity yet.') }}</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                        <div class="p-6 pl-7">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center h-9 w-9 rounded-full bg-amber-50 ring-1 ring-amber-200">
                                    <x-application-logo class="h-4 w-4 fill-current text-amber-500" />
                                </span>
                                <div>
                                    <p class="font-medium text-slate-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-slate-500">
                                        {{ Auth::user()->getRoleNames()->map(fn ($r) => ucfirst($r))->implode(', ') ?: 'No role assigned' }}
                                    </p>
                                </div>
                            </div>
                            <p class="mt-4 text-sm text-slate-500">
                                {{ __("Welcome back. Here's a snapshot of David's reception invitations.") }}
                            </p>
                        </div>
                    </div>

                    @role('superadmin')
                        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                            <div class="p-6 pl-7">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center h-9 w-9 rounded-lg bg-amber-50">
                                        <svg class="w-4.5 h-4.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                        </svg>
                                    </span>
                                    <h3 class="text-base font-medium text-slate-900">
                                        {{ __('Create User') }}
                                    </h3>
                                </div>

                                <x-flash-messages class="mt-4 px-3 py-2 text-xs" />

                                <form method="POST" action="{{ route('users.store') }}" class="mt-4 space-y-4">
                                    @csrf

                                    <div>
                                        <x-input-label for="user_name" :value="__('Name')" />
                                        <x-text-input id="user_name" name="name" type="text" class="block mt-1 w-full" :value="old('name')" required />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="user_email" :value="__('Email')" />
                                        <x-text-input id="user_email" name="email" type="email" class="block mt-1 w-full" :value="old('email')" required />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="user_password" :value="__('Password')" />
                                        <x-text-input id="user_password" name="password" type="password" class="block mt-1 w-full" required />
                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ __('At least 8 characters, with upper & lower case, a number and a symbol.') }}
                                        </p>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="user_role" :value="__('Role')" />
                                        <select id="user_role" name="role" required
                                            class="block mt-1 w-full border-slate-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm">
                                            <option value="" disabled selected>{{ __('Select a role') }}</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}" @selected(old('role') === $role->name)>
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                    </div>

                                    <x-primary-button class="w-full justify-center">
                                        {{ __('Create User') }}
                                    </x-primary-button>
                                </form>
                            </div>
                        </div>
                    @endrole

                    @role('admin|superadmin|checker')
                        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                            <div class="p-6 pl-7">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center h-9 w-9 rounded-lg bg-amber-50">
                                        <svg class="w-4.5 h-4.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                    </span>
                                    <h3 class="text-base font-medium text-slate-900">
                                        {{ __('Contributors') }}
                                    </h3>
                                </div>
                                <p class="mt-2 text-sm text-slate-500">
                                    {{ __('View and manage the reception guest list.') }}
                                </p>
                                @role('admin|superadmin')
                                    <div class="mt-4 flex flex-col gap-2">
                                        <a href="{{ route('contributors.list') }}"
                                            class="inline-flex w-full items-center justify-center px-4 py-2 bg-amber-400 border border-transparent rounded-md font-semibold text-xs text-slate-900 uppercase tracking-widest hover:bg-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('View Guest List') }}
                                        </a>
                                        <a href="{{ route('contributors.index') }}"
                                            class="inline-flex w-full items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('Manage Contributors') }}
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ route('contributors.list') }}"
                                        class="mt-4 inline-flex w-full items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('Check In Guests') }}
                                    </a>
                                @endrole
                            </div>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
