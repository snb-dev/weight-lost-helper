@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full border-l-4 border-lime-300 bg-white/10 py-2 ps-3 pe-4 text-start text-base font-medium text-white transition duration-150 ease-in-out focus:outline-none'
            : 'block w-full border-l-4 border-transparent py-2 ps-3 pe-4 text-start text-base font-medium text-slate-400 transition duration-150 ease-in-out hover:border-white/20 hover:bg-white/5 hover:text-white focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
