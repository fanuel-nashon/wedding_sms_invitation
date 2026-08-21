<div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
    <div class="p-6 pl-7">
        <h3 class="text-lg font-medium text-slate-900">{{ __('Guest List') }}</h3>
        <p class="mt-1 text-sm text-slate-500">{{ __('All contributors invited to the reception.') }}</p>

        @php
            $statusStyles = [
                'not_invited' => 'bg-slate-100 text-slate-600',
                'invited' => 'bg-amber-50 text-amber-700',
                'attended' => 'bg-emerald-50 text-emerald-700',
                'not_attended' => 'bg-rose-50 text-rose-700',
            ];
        @endphp

        <!-- Mobile: stacked cards -->
        <div class="mt-6 space-y-3 sm:hidden">
            @forelse ($contributors as $contributor)
                @php
                    $rowNumber = ($contributors->currentPage() - 1) * $contributors->perPage() + $loop->iteration;
                @endphp
                <div class="rounded-xl border border-slate-200 p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs text-slate-400 tabular-nums">#{{ $rowNumber }}</p>
                            <p class="font-medium text-slate-900 truncate">{{ $contributor->name }}</p>
                            <p class="text-sm text-slate-500 tabular-nums">{{ $contributor->phone_no }}</p>
                        </div>
                        <span class="shrink-0 inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusStyles[$contributor->status] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ ucfirst(str_replace('_', ' ', $contributor->status)) }}
                        </span>
                    </div>

                    <p class="mt-3 text-sm text-slate-500">
                        {{ __('Seats') }}: <span class="font-medium text-slate-700 tabular-nums">{{ $contributor->assigned_seats }}</span>
                    </p>

                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('contributors.edit', $contributor) }}"
                            class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-semibold uppercase tracking-widest text-slate-700 border border-slate-300 rounded-md shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                            {{ __('Edit') }}
                        </a>
                        @if ($contributor->status === 'invited')
                            <a href="{{ route('contributors.edit', $contributor) }}"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-semibold uppercase tracking-widest text-slate-700 border border-slate-300 rounded-md shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                {{ __('Send Card') }}
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-slate-500">{{ __('No contributors yet.') }}</p>
            @endforelse
        </div>

        <!-- sm and up: table -->
        <div class="mt-6 hidden sm:block overflow-x-auto rounded-lg border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="py-3 pl-4 pr-3 w-12 text-right">{{ __('#') }}</th>
                        <th class="py-3 pr-4">{{ __('Name') }}</th>
                        <th class="py-3 pr-4">{{ __('Phone') }}</th>
                        <th class="py-3 pr-4 text-right">{{ __('Seats') }}</th>
                        <th class="py-3 pr-4">{{ __('Status') }}</th>
                        <th class="py-3 pr-4"></th>
                        <th class="py-3 pr-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($contributors as $contributor)
                        @php
                            $rowNumber = ($contributors->currentPage() - 1) * $contributors->perPage() + $loop->iteration;
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 pl-4 pr-3 text-right text-slate-400 tabular-nums">{{ $rowNumber }}</td>
                            <td class="py-3 pr-4 font-medium text-slate-900 whitespace-nowrap">{{ $contributor->name }}</td>
                            <td class="py-3 pr-4 text-slate-500 whitespace-nowrap tabular-nums">{{ $contributor->phone_no }}</td>
                            <td class="py-3 pr-4 text-right text-slate-700 tabular-nums">{{ $contributor->assigned_seats }}</td>
                            <td class="py-3 pr-4">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusStyles[$contributor->status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst(str_replace('_', ' ', $contributor->status)) }}
                                </span>
                            </td>
                            <td class="py-3 pr-4 text-right">
                                <a href="{{ route('contributors.edit', $contributor) }}"
                                    class="inline-flex items-center px-3 py-1 text-xs font-semibold uppercase tracking-widest text-slate-700 border border-slate-300 rounded-md shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    {{ __('Edit') }}
                                </a>
                            </td>
                            <td class="py-3 pr-4 text-right">
                                @if ($contributor->status === 'invited')
                                    <a href="{{ route('contributors.edit', $contributor) }}"
                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold uppercase tracking-widest text-slate-700 border border-slate-300 rounded-md shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                        {{ __('Send Card') }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-sm text-slate-500">
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
