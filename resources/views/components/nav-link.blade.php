@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-amber-400 text-sm font-medium leading-5 text-white focus:outline-none focus:border-amber-300 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-stone-400 hover:text-stone-200 hover:border-stone-600 focus:outline-none focus:text-stone-200 focus:border-stone-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
