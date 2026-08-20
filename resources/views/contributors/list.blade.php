<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Guest List') }}
                </h2>
            </div>
            <a href="{{ route('contributors.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                {{ __('Add / Import Contributors') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('contributors._guest-list', ['contributors' => $contributors])
        </div>
    </div>
</x-app-layout>
