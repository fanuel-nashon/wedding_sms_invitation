@props(['class' => 'mt-4 px-4 py-3 text-sm'])

@if (session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="{{ $class }} rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700"
    >
        {{ session('success') }}
    </div>
@endif

@if (session('failure'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="{{ $class }} rounded-lg bg-rose-50 border border-rose-200 text-rose-700"
    >
        {{ session('failure') }}
    </div>
@endif
