<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Guest List') }}
                </h2>
            </div>
            <div class="flex flex-wrap gap-2">
                @role('admin|superadmin')
                    <a href="{{ route('contributors.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        {{ __('Add / Import Contributors') }}
                    </a>
                @endrole
                @role('superadmin')
                    <a href="{{ route('contributors.undelivered') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        {{ __('Undelivered SMS') }}
                    </a>
                    <a href="{{ route('contributors.trashed') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        {{ __('Deleted Contributors') }}
                    </a>
                @endrole
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="GET" action="{{ route('contributors.list') }}"
                class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                <div class="p-6 pl-7 flex flex-col gap-4 sm:flex-row sm:items-end">
                    <div class="flex-1">
                        <x-input-label for="search" :value="__('Search by name or entry code')" />
                        <x-text-input id="search" name="search" type="text" class="block mt-1 w-full"
                            value="{{ request('search') }}" placeholder="{{ __('e.g. Jane Doe or ROTEAFOF') }}" />
                    </div>

                    <div class="sm:w-48">
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status"
                            class="block mt-1 w-full border-slate-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm">
                            <option value="">{{ __('All statuses') }}</option>
                            @foreach (['not_invited', 'invited', 'attended', 'not_attended'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <x-primary-button class="justify-center">{{ __('Filter') }}</x-primary-button>
                        @if (request()->hasAny(['search', 'status']))
                            <a href="{{ route('contributors.list') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50">
                                {{ __('Clear') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            @include('contributors._guest-list', ['contributors' => $contributors])
        </div>
    </div>
</x-app-layout>
