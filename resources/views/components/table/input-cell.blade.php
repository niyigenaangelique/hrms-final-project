@props([
    'hasLeftBorder' => false,
    'hasRightBorder' => true,
    'hasTopBorder' => true,
    'hasBottomBorder' => true,
    'hasError' => false,
    'rowIndex' => 0,
    ])

<td class="p-0">
    <input
        class="ps-3 text-base sm:text-sm mt-[-1px] py-2 h-8 w-full border border-dashed
               {{ $hasError ? 'border-red-500' : 'border-zinc-600'}}
               {{ $hasLeftBorder ? 'border-l-1' : 'border-l-0' }}
               {{ $hasRightBorder ? 'border-r-1' : 'border-r-0' }}
               {{ $hasTopBorder ? 'border-t-1' : 'border-t-0' }}
               {{ $hasBottomBorder ? 'border-b-1' : 'border-b-0' }}
               rounded-none block disabled:shadow-none dark:shadow-none focus:outline-none"
        {{ $attributes }}

    >
</td>
