@props(['name', 'placeholder' => null, 'value' => null, 'required' => false])

<div class="mb-2">
    <textarea class="border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm w-full" rows="4" name="{{ $name }}"
        id="{{ $name }}" placeholder="{{ $placeholder }}" type="textarea">{{ $value }}</textarea>
</div>
