@props([
    'hasLeftBorder' => false,
    'hasRightBorder' => true,
    'hasTopBorder' => true,
    'hasBottomBorder' => true,
    'hasError' => false,
    'options' => [],
    'value' => null,
    'placeholder'   => 'Select...',
    'name' => null,
    'id' => 'select-' . uniqid(),
    'class' => '',
])

<td class="p-0">
    <div class="p-0 scrollbar-custom !max-h-[100px]">
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            class="scrollbar-custom ps-4 min-w-[150px] bg-transparent text-base sm:text-sm mt-[-1px] py-0 h-8 w-full border border-dashed border-zinc-600
               {{ $hasLeftBorder ? 'border-l-1' : 'border-l-0' }}
               {{ $hasRightBorder ? 'border-r-1' : 'border-r-0' }}
               {{ $hasTopBorder ? 'border-t-1' : 'border-t-0' }}
               {{ $hasBottomBorder ? 'border-b-1' : 'border-b-0' }}
                   rounded-none block disabled:shadow-none dark:shadow-none focus:outline-none {{ $class }}"
            {{ $attributes }}
        >
            <option value="">{{ $placeholder ?? 'Select...' }}</option>
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    </div>
</td>
