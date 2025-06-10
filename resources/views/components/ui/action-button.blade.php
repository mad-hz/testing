@props([
    'type',
    'href' => null,
    'modal' => null,
])

@php
    $icons = [
        'back' => 'icon-[tabler--arrow-left]',
        'edit' => 'icon-[tabler--edit]',
        'delete' => 'icon-[tabler--trash]',
        'validation' => 'icon-[tabler--flag]',
    ];

    $colors = [
        'back' => '!bg-gray-200 !text-gray-700 !hover:bg-gray-300',
        'edit' => '!bg-orange-200 !text-orange-700 !hover:bg-orange-300',
        'delete' => '!bg-red-200 !text-red-700 !hover:bg-red-300',
        'validation' => '!bg-blue-200 !text-blue-700 !hover:bg-blue-300',
    ];

    $icon = $icons[$type] ?? 'icon-[tabler--question-mark]';
    $classes = $colors[$type] ?? 'bg-gray-100 text-gray-600';
@endphp

@if($modal)
    <x-ui.button
        type="button"
        class="p-2 w-auto h-auto {{ $classes }}"
        x-data
        x-on:click="$dispatch('open-modal', '{{ $modal }}')"
    >
        <span class="{{ $icon }} size-5 m-0"></span>
    </x-ui.button>
@elseif($href)
    <x-ui.button
        href="{{ $href }}"
        class="p-2 w-auto h-auto {{ $classes }}"
    >
        <span class="{{ $icon }} size-5 m-0"></span>
    </x-ui.button>
@endif
