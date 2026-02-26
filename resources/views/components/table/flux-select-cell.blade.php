@props([
    'name'          => null,
    'options'       => [],
    'value'         => null,
    'placeholder'   => 'Select...',
    'hasLeftBorder' => true,
    'class'         => '',
])

@php
    $borderClass = $hasLeftBorder ? 'border-l-0' : '';
@endphp

<td class="p-0">
    <flux:select
        name="{{ $name }}"
        wire:model.defer="{{ $attributes->wire('model')->value() }}"
        placeholder="{{ $placeholder }}"
        variant="listbox"
        searchable

        class="!ps-0 text-base sm:text-sm !mt-[-1px] !py-0 !h-8 w-full !border-none
               {{ $borderClass }} rounded-none block focus:outline-none bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 {{ $class }}"
    >
        @foreach ($options as $key => $label)
            <flux:select.option value="{{ $key }}">{{ $label }}</flux:select.option>
        @endforeach
    </flux:select>
</td>
