<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('System Logs') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="GET" action="{{ route('logs.index') }}"
                class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                <div class="p-6 pl-7 flex flex-col gap-4 sm:flex-row sm:items-end">
                    <div class="flex-1">
                        <x-input-label for="search" :value="__('Search by user or action')" />
                        <x-text-input id="search" name="search" type="text" class="block mt-1 w-full"
                            value="{{ request('search') }}" placeholder="{{ __('e.g. Fanuel or Sent invitation') }}" />
                    </div>

                    <div class="sm:w-48">
                        <x-input-label for="module" :value="__('Module')" />
                        <select id="module" name="module"
                            class="block mt-1 w-full border-slate-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm">
                            <option value="">{{ __('All modules') }}</option>
                            @foreach ($modules as $module)
                                <option value="{{ $module }}" @selected(request('module') === $module)>
                                    {{ $module }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <x-primary-button class="justify-center">{{ __('Filter') }}</x-primary-button>
                        @if (request()->hasAny(['search', 'module']))
                            <a href="{{ route('logs.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50">
                                {{ __('Clear') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                <div class="p-6 pl-7">
                    <h3 class="text-lg font-medium text-slate-900">{{ __('Activity Log') }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ __('Every logged action across the system.') }}</p>

                    <!-- Mobile: stacked cards -->
                    <div class="mt-6 space-y-3 sm:hidden">
                        @forelse ($logs as $log)
                            <div class="rounded-xl border border-slate-200 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-violet-50 text-violet-700">
                                        {{ $log->module }}
                                    </span>
                                    <span class="text-xs text-slate-400 shrink-0">{{ $log->action_time?->diffForHumans() }}</span>
                                </div>
                                <p class="mt-2 text-sm text-slate-800">
                                    <span class="font-medium">{{ $log->user_name }}</span>
                                    {{ $log->action }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">{{ $log->user_email }}</p>
                            </div>
                        @empty
                            <p class="py-6 text-center text-sm text-slate-500">{{ __('No log entries found.') }}</p>
                        @endforelse
                    </div>

                    <!-- sm and up: table -->
                    <div class="mt-6 hidden sm:block overflow-x-auto rounded-lg border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50">
                                <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    <th class="py-3 pl-4 pr-4">{{ __('Module') }}</th>
                                    <th class="py-3 pr-4">{{ __('User') }}</th>
                                    <th class="py-3 pr-4">{{ __('Action') }}</th>
                                    <th class="py-3 pr-4 text-right">{{ __('When') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse ($logs as $log)
                                    <tr class="hover:bg-slate-50">
                                        <td class="py-3 pl-4 pr-4">
                                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-violet-50 text-violet-700">
                                                {{ $log->module }}
                                            </span>
                                        </td>
                                        <td class="py-3 pr-4 whitespace-nowrap">
                                            <div class="font-medium text-slate-900">{{ $log->user_name }}</div>
                                            <div class="text-xs text-slate-400">{{ $log->user_email }}</div>
                                        </td>
                                        <td class="py-3 pr-4 text-slate-700">{{ $log->action }}</td>
                                        <td class="py-3 pr-4 text-right text-slate-400 whitespace-nowrap"
                                            title="{{ $log->action_time }}">
                                            {{ $log->action_time?->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-sm text-slate-500">
                                            {{ __('No log entries found.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
