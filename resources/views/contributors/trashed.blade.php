<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Deleted Contributors') }}
                </h2>
            </div>
            <a href="{{ route('contributors.list') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                {{ __('Back to Guest List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="GET" action="{{ route('contributors.trashed') }}"
                class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-rose-400 to-rose-600"></div>
                <div class="p-6 pl-7 flex flex-col gap-4 sm:flex-row sm:items-end">
                    <div class="flex-1">
                        <x-input-label for="search" :value="__('Search by name or entry code')" />
                        <x-text-input id="search" name="search" type="text" class="block mt-1 w-full"
                            value="{{ request('search') }}" placeholder="{{ __('e.g. Jane Doe or ROTEAFOF') }}" />
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <x-primary-button class="justify-center">{{ __('Filter') }}</x-primary-button>
                        @if (request()->hasAny(['search']))
                            <a href="{{ route('contributors.trashed') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50">
                                {{ __('Clear') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-rose-400 to-rose-600"></div>
                <div class="p-6 pl-7">
                    <h3 class="text-lg font-medium text-slate-900">{{ __('Trash') }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ __('Deleted contributors can be restored from here.') }}</p>

                    @if (session('success'))
                        <div class="mt-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Mobile: stacked cards -->
                    <div class="mt-6 space-y-3 sm:hidden">
                        @forelse ($contributors as $contributor)
                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="font-medium text-slate-900 truncate">{{ $contributor->name }}</p>
                                <p class="text-sm text-slate-500 tabular-nums">{{ $contributor->phone_no }}</p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ __('Deleted') }} {{ $contributor->deleted_at?->diffForHumans() }}
                                </p>
                                <form method="POST" action="{{ route('contributors.restore', $contributor->id) }}" class="mt-3">
                                    @csrf
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-3 py-2 text-xs font-semibold uppercase tracking-widest text-emerald-700 border border-emerald-300 rounded-md shadow-sm hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                        {{ __('Restore') }}
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="py-6 text-center text-sm text-slate-500">{{ __('No deleted contributors.') }}</p>
                        @endforelse
                    </div>

                    <!-- sm and up: table -->
                    <div class="mt-6 hidden sm:block overflow-x-auto rounded-lg border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50">
                                <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    <th class="py-3 pl-4 pr-4">{{ __('Name') }}</th>
                                    <th class="py-3 pr-4">{{ __('Phone') }}</th>
                                    <th class="py-3 pr-4">{{ __('Deleted') }}</th>
                                    <th class="py-3 pr-4 text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse ($contributors as $contributor)
                                    <tr class="hover:bg-slate-50">
                                        <td class="py-3 pl-4 pr-4 font-medium text-slate-900 whitespace-nowrap">{{ $contributor->name }}</td>
                                        <td class="py-3 pr-4 text-slate-500 whitespace-nowrap tabular-nums">{{ $contributor->phone_no }}</td>
                                        <td class="py-3 pr-4 text-slate-400 whitespace-nowrap" title="{{ $contributor->deleted_at }}">
                                            {{ $contributor->deleted_at?->diffForHumans() }}
                                        </td>
                                        <td class="py-3 pr-4 text-right">
                                            <form method="POST" action="{{ route('contributors.restore', $contributor->id) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 text-xs font-semibold uppercase tracking-widest text-emerald-700 border border-emerald-300 rounded-md shadow-sm hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                                    {{ __('Restore') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-sm text-slate-500">
                                            {{ __('No deleted contributors.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $contributors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
