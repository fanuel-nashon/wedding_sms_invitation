@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-amber-400 text-start text-base font-medium text-amber-300 bg-stone-800/60 focus:outline-none focus:text-amber-200 focus:bg-stone-800 focus:border-amber-300 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-stone-400 hover:text-stone-200 hover:bg-stone-800/60 hover:border-stone-600 focus:outline-none focus:text-stone-200 focus:bg-stone-800/60 focus:border-stone-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
