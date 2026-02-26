@props([
    'hasLeftBorder' => true,
    'options' => [],
    'value' => null,
    'name' => null,
    'class' => '',
])

<td class="p-0">
    <select
        name="{{ $name }}"
        class="ps-[1.375rem] text-base sm:text-sm mt-[-1px] py-2 h-8 w-full border border-dashed border-zinc-600
               {{ $hasLeftBorder ? 'border-l-0' : '' }}
               rounded-none block disabled:shadow-none dark:shadow-none focus:outline-none {{ $class }}"
        {{ $attributes }}
    >
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
</td>
