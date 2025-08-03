@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-yellow-500 text-start text-base font-medium text-yellow-500 bg-gray-800 focus:outline-none focus:text-yellow-400 focus:bg-gray-700 focus:border-yellow-600 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-yellow-500 hover:bg-gray-800 hover:border-yellow-500 focus:outline-none focus:text-yellow-400 focus:bg-gray-800 focus:border-yellow-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
