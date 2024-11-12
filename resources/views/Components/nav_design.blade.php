@props(['active' => false])

@php
    $classes = $active
        ? 'bg-yellow-700 text-white rounded-md px-3 py-2 text-[18px] font-bold'
        : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-yellow-700 rounded-md px-3 py-2 text-[18px] font-medium';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} aria-current="{{ $active ? 'page' : 'false' }}">
    {{ $slot }}
</a>
