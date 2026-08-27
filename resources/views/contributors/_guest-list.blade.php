<div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-violet-400 to-violet-600"></div>
    <div class="p-6 pl-7">
        <h3 class="text-lg font-medium text-slate-900">{{ __('Guest List') }}</h3>
        <p class="mt-1 text-sm text-slate-500">{{ __('All contributors invited to the reception.') }}</p>

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

                    <form method="POST" action="{{ route('contributors.seats', $contributor) }}" class="mt-3 flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <label for="seats_{{ $contributor->id }}_m" class="text-sm text-slate-500">{{ __('Seats') }}</label>
                        <input id="seats_{{ $contributor->id }}_m" type="number" name="assigned_seats" min="0"
                            value="{{ $contributor->assigned_seats }}"
                            class="w-16 text-right text-sm border-slate-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500" />
                        <button type="submit" class="text-xs font-semibold uppercase tracking-widest text-amber-600 hover:text-amber-700">
                            {{ __('Save') }}
                        </button>
                    </form>

                    <div class="mt-3 flex flex-wrap gap-2">
                        @role('admin|superadmin')
                            <a href="{{ route('contributors.edit', $contributor) }}"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-semibold uppercase tracking-widest text-slate-700 border border-slate-300 rounded-md shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                {{ __('Edit') }}
                            </a>
                            @if ($contributor->status === 'invited')
                                <form method="POST" action="{{ route('contributors.send-sms', $contributor) }}" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-3 py-2 text-xs font-semibold uppercase tracking-widest text-slate-700 border border-slate-300 rounded-md shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                        {{ __('Send SMS') }}
                                    </button>
                                </form>
                            @endif
                        @endrole

                        @role('superadmin')
                            <form method="POST" action="{{ route('contributors.destroy', $contributor) }}" class="flex-1"
                                onsubmit="return confirm('{{ __('Delete this contributor? This can be undone by a superadmin.') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-3 py-2 text-xs font-semibold uppercase tracking-widest text-rose-700 border border-rose-300 rounded-md shadow-sm hover:bg-rose-50 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        @endrole

                        @if ($contributor->status === 'invited')
                            <form method="POST" action="{{ route('contributors.attend', $contributor) }}" class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-3 py-2 text-xs font-semibold uppercase tracking-widest text-emerald-700 border border-emerald-300 rounded-md shadow-sm hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                    {{ __('Confirm Attended') }}
                                </button>
                            </form>
                        @elseif ($contributor->status === 'attended')
                            <span class="flex-1 inline-flex items-center justify-center text-xs font-medium text-emerald-600">
                                {{ __('Checked in') }}
                            </span>
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
                            <td class="py-3 pr-4 text-right">
                                <form method="POST" action="{{ route('contributors.seats', $contributor) }}" class="flex items-center justify-end gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="assigned_seats" min="0" value="{{ $contributor->assigned_seats }}"
                                        class="w-16 text-right text-sm border-slate-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500" />
                                    <button type="submit" class="text-xs font-semibold uppercase tracking-widest text-amber-600 hover:text-amber-700">
                                        {{ __('Save') }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 pr-4">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusStyles[$contributor->status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst(str_replace('_', ' ', $contributor->status)) }}
                                </span>
                            </td>
                            <td class="py-3 pr-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @role('admin|superadmin')
                                        <a href="{{ route('contributors.edit', $contributor) }}"
                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold uppercase tracking-widest text-slate-700 border border-slate-300 rounded-md shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                            {{ __('Edit') }}
                                        </a>
                                    @endrole
                                    @role('superadmin')
                                        <form method="POST" action="{{ route('contributors.destroy', $contributor) }}"
                                            onsubmit="return confirm('{{ __('Delete this contributor? This can be undone by a superadmin.') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 text-xs font-semibold uppercase tracking-widest text-rose-700 border border-rose-300 rounded-md shadow-sm hover:bg-rose-50 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    @endrole
                                </div>
                            </td>
                            <td class="py-3 pr-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @role('admin|superadmin')
                                        @if ($contributor->status === 'invited')
                                            <form method="POST" action="{{ route('contributors.send-sms', $contributor) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 text-xs font-semibold uppercase tracking-widest text-slate-700 border border-slate-300 rounded-md shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                                    {{ __('Send SMS') }}
                                                </button>
                                            </form>
                                        @endif
                                    @endrole

                                    @if ($contributor->status === 'invited')
                                        <form method="POST" action="{{ route('contributors.attend', $contributor) }}">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 text-xs font-semibold uppercase tracking-widest text-emerald-700 border border-emerald-300 rounded-md shadow-sm hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                                {{ __('Confirm Attended') }}
                                            </button>
                                        </form>
                                    @elseif ($contributor->status === 'attended')
                                        <span class="text-xs font-medium text-emerald-600">{{ __('Checked in') }}</span>
                                    @endif
                                </div>
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
