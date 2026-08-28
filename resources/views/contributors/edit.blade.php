<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Edit Contributor') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                <div class="p-6 pl-7">
                    <h3 class="text-lg font-medium text-slate-900">{{ __('Edit Contributor') }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ __('Update this guest\'s details.') }}</p>

                    <x-flash-messages />

                    <form method="POST" action="{{ route('contributors.update', $contributor) }}" class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="contributor_name" :value="__('Name')" />
                            <x-text-input id="contributor_name" name="name" type="text" class="block mt-1 w-full" :value="old('name', $contributor->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="contributor_phone" :value="__('Phone Number')" />
                            <x-text-input id="contributor_phone" name="phone_no" type="text" inputmode="numeric" placeholder="255738234345"
                                class="block mt-1 w-full" :value="old('phone_no', $contributor->phone_no)" required />
                            <p class="mt-1 text-xs text-slate-500">
                                {{ __('International format only, e.g. 255738234345 — no leading 0 or +.') }}
                            </p>
                            <x-input-error :messages="$errors->get('phone_no')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="contributor_seats" :value="__('Assigned Seats')" />
                            <x-text-input id="contributor_seats" name="assigned_seats" type="number" min="0" class="block mt-1 w-full" :value="old('assigned_seats', $contributor->assigned_seats)" required />
                            <x-input-error :messages="$errors->get('assigned_seats')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="contributor_status" :value="__('Status')" />
                            <select id="contributor_status" name="status" required
                                class="block mt-1 w-full border-slate-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm">
                                @foreach (['not_invited', 'invited'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $contributor->status) === $status)>
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2 flex items-center justify-end gap-3">
                            <a href="{{ route('contributors.list') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Save Changes') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
