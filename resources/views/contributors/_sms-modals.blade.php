@role('superadmin')
    <x-modal name="sms-preview" maxWidth="lg">
        <div class="p-6" x-data="{ message: '', guestName: '', copied: false }"
            x-on:sms-preview-loaded.window="message = $event.detail.message; guestName = $event.detail.guestName; copied = false">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Invitation SMS') }} <span x-show="guestName" x-text="'— ' + guestName"></span>
            </h2>
            <p class="mt-1 text-sm text-slate-500">{{ __('Copy this text to send it manually whenever you like.') }}</p>

            <textarea readonly rows="12" x-model="message" onclick="this.select()"
                class="mt-4 block w-full text-sm font-mono border-slate-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500"></textarea>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close-modal', 'sms-preview')"
                    class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    {{ __('Close') }}
                </button>
                <button type="button"
                    x-on:click="navigator.clipboard.writeText(message).then(() => { copied = true; setTimeout(() => copied = false, 2000); })"
                    class="inline-flex items-center justify-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <span x-show="!copied">{{ __('Copy') }}</span>
                    <span x-show="copied" x-cloak>{{ __('Copied!') }}</span>
                </button>
            </div>
        </div>
    </x-modal>

    <x-modal name="delivery-status" maxWidth="sm">
        <div class="p-6" x-data="{ status: null, messageId: null, updatedAt: null, guestName: '' }"
            x-on:delivery-status-loaded.window="status = $event.detail.status; messageId = $event.detail.messageId; updatedAt = $event.detail.updatedAt; guestName = $event.detail.guestName">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Delivery Status') }} <span x-show="guestName" x-text="'— ' + guestName"></span>
            </h2>

            <div class="mt-4 space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-slate-500">{{ __('Status') }}</span>
                    <span
                        x-text="status ? status : 'Not sent yet'"
                        class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium"
                        :class="{
                            'bg-emerald-50 text-emerald-700': status === 'DELIVERED',
                            'bg-rose-50 text-rose-700': status === 'FAILED' || status === 'REJECTED' || status === 'UNDELIVERED',
                            'bg-amber-50 text-amber-700': status === 'PENDING' || status === 'ENROUTE',
                            'bg-slate-100 text-slate-600': !status,
                        }"
                    ></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500">{{ __('Message ID') }}</span>
                    <span class="text-slate-700 font-mono text-xs" x-text="messageId || '—'"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500">{{ __('Last updated') }}</span>
                    <span class="text-slate-700" x-text="updatedAt || '—'"></span>
                </div>
            </div>

            <p class="mt-4 text-xs text-slate-500">
                {{ __('Status is reported by the SMS gateway via webhook and may take a moment to arrive after sending.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close-modal', 'delivery-status')"
                    class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </x-modal>

    <script>
        function loadSmsPreview(url, guestName) {
            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then((response) => response.json())
                .then((data) => {
                    window.dispatchEvent(new CustomEvent('sms-preview-loaded', { detail: { message: data.message, guestName: guestName } }));
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'sms-preview' }));
                });
        }

        function loadDeliveryStatus(url, guestName) {
            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then((response) => response.json())
                .then((data) => {
                    window.dispatchEvent(new CustomEvent('delivery-status-loaded', { detail: { status: data.status, messageId: data.messageId, updatedAt: data.updatedAt, guestName: guestName } }));
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delivery-status' }));
                });
        }
    </script>
@endrole
