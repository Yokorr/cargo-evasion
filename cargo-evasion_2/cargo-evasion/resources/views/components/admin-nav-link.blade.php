@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-emerald-500 text-black font-black flex items-center p-3 rounded-2xl transition-all'
            : 'text-gray-400 hover:text-white flex items-center p-3 rounded-2xl transition-all hover:bg-gray-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>