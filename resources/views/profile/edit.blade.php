<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-amber-400 to-amber-600"></div>
                <div class="p-4 sm:p-8 pl-6 sm:pl-9">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-amber-400 to-amber-600"></div>
                <div class="p-4 sm:p-8 pl-6 sm:pl-9">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-rose-400 to-rose-600"></div>
                <div class="p-4 sm:p-8 pl-6 sm:pl-9">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
