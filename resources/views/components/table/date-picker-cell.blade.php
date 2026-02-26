@props([
    'hasLeftBorder' => false,
    'hasRightBorder' => true,
    'hasTopBorder' => true,
    'hasBottomBorder' => true,
    'hasError' => false,
    'rowIndex' => 0,
    ])

<td class="p-0">
    <flux:date-picker selectable-header with-today
        class=" !mt-[-1px] !h-8 !bg-transparent !text-left !text-base sm:!text-sm border border-dashed
               {{ $hasError ? 'border-red-500' : 'border-zinc-600'}}
               {{ $hasLeftBorder ? 'border-l-1' : 'border-l-0' }}
               {{ $hasRightBorder ? 'border-r-1' : 'border-r-0' }}
               {{ $hasTopBorder ? 'border-t-1' : 'border-t-0' }}
               {{ $hasBottomBorder ? 'border-b-1' : 'border-b-0' }}
        "
        {{ $attributes }}
    >
        <x-slot name="trigger">
            <flux:date-picker.input />
        </x-slot>
    </flux:date-picker>
</td>
