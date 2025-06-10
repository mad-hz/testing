@props([
    'variant' => 'primary',
    'type' => 'button',
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center text-center rounded-md transition ease-in-out duration-150 shadow-sm';

    $variants = [
        'primary' => 'bg-red-600 text-white hover:bg-red-700',
        'gray' => 'bg-gray-200 text-gray-700 hover:bg-gray-300',
        'ghost' => 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50',
        'no' => 'bg-white text-black !shadow-none p-0',
    ];

    $variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$baseClasses $variantClass"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$baseClasses $variantClass"]) }}>
        {{ $slot }}
    </button>
@endif
