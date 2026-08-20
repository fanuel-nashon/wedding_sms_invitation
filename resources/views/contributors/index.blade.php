<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Contributors') }}
                </h2>
            </div>
            <a href="{{ route('contributors.list') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-amber-400 border border-transparent rounded-md font-semibold text-xs text-slate-900 uppercase tracking-widest hover:bg-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                {{ __('View Guest List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                <div class="p-6 pl-7">
                    <h3 class="text-lg font-medium text-slate-900">{{ __('Add Contributor') }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ __('Add a new guest to the reception list.') }}</p>

                    @if (session('success'))
                        <div class="mt-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('failure'))
                        <div class="mt-4 rounded-lg bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
                            {{ session('failure') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contributors.store') }}" class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @csrf

                        <div>
                            <x-input-label for="contributor_name" :value="__('Name')" />
                            <x-text-input id="contributor_name" name="name" type="text" class="block mt-1 w-full" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="contributor_phone" :value="__('Phone Number')" />
                            <x-text-input id="contributor_phone" name="phone_no" type="text" inputmode="numeric" placeholder="255738234345"
                                class="block mt-1 w-full" :value="old('phone_no')" required />
                            <p class="mt-1 text-xs text-slate-500">
                                {{ __('International format only, e.g. 255738234345 — no leading 0 or +.') }}
                            </p>
                            <x-input-error :messages="$errors->get('phone_no')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="contributor_seats" :value="__('Assigned Seats')" />
                            <x-text-input id="contributor_seats" name="assigned_seats" type="number" min="0" class="block mt-1 w-full" :value="old('assigned_seats', 0)" required />
                            <x-input-error :messages="$errors->get('assigned_seats')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="contributor_status" :value="__('Status')" />
                            <select id="contributor_status" name="status" required
                                class="block mt-1 w-full border-slate-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm">
                                @foreach (['not_invited', 'invited'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', 'not_invited') === $status)>
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2 flex justify-end">
                            <x-primary-button>
                                {{ __('Add Contributor') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                <div class="p-6 pl-7">
                    <h3 class="text-lg font-medium text-slate-900">{{ __('Import Contributors') }}</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ __('Upload an .xlsx or .csv file with columns: name, phone_no, assigned_seats, status. Phone numbers must be in international format (e.g. 255738234345).') }}
                    </p>

                    <a href="{{ route('contributors.template') }}"
                        class="mt-2 inline-flex items-center text-sm text-amber-600 hover:text-amber-700 underline">
                        {{ __('Download template') }}
                    </a>

                    <form method="POST" action="{{ route('contributors.import') }}" enctype="multipart/form-data" class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-end">
                        @csrf
                        <div class="flex-1">
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                class="block w-full text-sm text-slate-600 border border-slate-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500" />
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>
                        <x-primary-button class="justify-center">{{ __('Import') }}</x-primary-button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
