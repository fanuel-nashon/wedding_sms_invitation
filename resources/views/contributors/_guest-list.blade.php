<div class="relative overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
    <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-amber-400 to-amber-600"></div>
    <div class="p-6 pl-7">
        <h3 class="text-lg font-medium text-stone-900">{{ __('Guest List') }}</h3>
        <p class="mt-1 text-sm text-stone-500">{{ __('All contributors invited to the reception.') }}</p>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200">
                <thead>
                    <tr class="text-left text-xs font-medium uppercase tracking-wide text-stone-500">
                        <th class="py-2 pr-4">{{ __('Name') }}</th>
                        <th class="py-2 pr-4">{{ __('Phone') }}</th>
                        <th class="py-2 pr-4">{{ __('Seats') }}</th>
                        <th class="py-2 pr-4">{{ __('Status') }}</th>
                        <th class="py-2 pr-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($contributors as $contributor)
                        @php
                            $statusStyles = [
                                'not_invited' => 'bg-stone-100 text-stone-600',
                                'invited' => 'bg-amber-50 text-amber-700',
                                'attended' => 'bg-emerald-50 text-emerald-700',
                                'not_attended' => 'bg-rose-50 text-rose-700',
                            ];
                        @endphp
                        <tr>
                            <td class="py-3 pr-4 text-sm text-stone-900">{{ $contributor->name }}</td>
                            <td class="py-3 pr-4 text-sm text-stone-500">{{ $contributor->phone_no }}</td>
                            <td class="py-3 pr-4 text-sm text-stone-500">{{ $contributor->assigned_seats }}</td>
                            <td class="py-3 pr-4">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusStyles[$contributor->status] ?? 'bg-stone-100 text-stone-600' }}">
                                    {{ ucfirst(str_replace('_', ' ', $contributor->status)) }}
                                </span>
                            </td>
                            <td class="py-3 pr-4 text-right">
                                <a href="{{ route('contributors.edit', $contributor) }}"
                                    class="inline-flex items-center px-3 py-1 text-xs font-semibold uppercase tracking-widest text-stone-700 border border-stone-300 rounded-md shadow-sm hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    {{ __('Edit') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-sm text-stone-500">
                                {{ __('No contributors yet.') }}
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
