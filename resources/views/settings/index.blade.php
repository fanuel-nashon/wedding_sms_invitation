<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
                <div class="p-6 pl-7">
                    <h3 class="text-lg font-medium text-slate-900">{{ __('SMS Gateway') }}</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ __('Credentials used to send SMS invitations via messaging-service.co.tz.') }}
                    </p>

                    <x-flash-messages />

                    <form method="POST" action="{{ route('settings.update') }}" class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="sms_username" :value="__('SMS Username')" />
                            <x-text-input id="sms_username" name="sms_username" type="text" class="block mt-1 w-full"
                                :value="old('sms_username', $settings->sms_username)" required />
                            <x-input-error :messages="$errors->get('sms_username')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="sms_sender_id" :value="__('Sender ID')" />
                            <x-text-input id="sms_sender_id" name="sms_sender_id" type="text" class="block mt-1 w-full"
                                :value="old('sms_sender_id', $settings->sms_sender_id)" required />
                            <p class="mt-1 text-xs text-slate-500">
                                {{ __('Must be an approved sender ID linked to an active outlet on your gateway account.') }}
                            </p>
                            <x-input-error :messages="$errors->get('sms_sender_id')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="sms_url" :value="__('API Base URL')" />
                            <x-text-input id="sms_url" name="sms_url" type="text" class="block mt-1 w-full"
                                placeholder="https://messaging-service.co.tz/" :value="old('sms_url', $settings->sms_url)" required />
                            <x-input-error :messages="$errors->get('sms_url')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="sms_token" :value="__('API Token')" />
                            <x-text-input id="sms_token" name="sms_token" type="password" class="block mt-1 w-full"
                                autocomplete="off" placeholder="{{ $settings->sms_token !== '' ? __('•••••••••• (unchanged)') : '' }}" />
                            <p class="mt-1 text-xs text-slate-500">
                                {{ __('Leave blank to keep the current token.') }}
                            </p>
                            <x-input-error :messages="$errors->get('sms_token')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="sms_password" :value="__('SMS Password')" />
                            <x-text-input id="sms_password" name="sms_password" type="password" class="block mt-1 w-full"
                                autocomplete="off" placeholder="{{ $settings->sms_password !== '' ? __('•••••••••• (unchanged)') : '' }}" />
                            <p class="mt-1 text-xs text-slate-500">
                                {{ __('Leave blank to keep the current password.') }}
                            </p>
                            <x-input-error :messages="$errors->get('sms_password')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2 flex justify-end">
                            <x-primary-button>
                                {{ __('Save Settings') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
