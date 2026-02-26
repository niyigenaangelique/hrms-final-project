@props([
    'options' => [],
    'value' => null,
    'name' => null,
    'hasLeftBorder' => true,
    'id' => 'listbox-' . uniqid(),
    'class' => '',
])

@php
    $selected = $options[$value] ?? 'Select...';
@endphp

<td class="p-0">
    <div
        x-data="{
            open: false,
            selected: '{{ $selected }}',
            value: '{{ $value }}',
            choose(val, label) {
                this.value = val;
                this.selected = label;
                this.open = false;
                $refs.input.value = val;
                $dispatch('input');
            }
        }"
        @click.away="open = false"
        class="relative"
    >
        <!-- Hidden input for Livewire or form submission -->
        <input
            type="hidden"
            name="{{ $name }}"
            x-ref="input"
            :value="value"
            class="hidden"
            {{ $attributes }}
        />

        <button type="button"
                @click="open = !open"
                class="ps-[1.375rem] text-left text-base sm:text-sm mt-[-1px] py-2 h-8 w-full border border-dashed border-zinc-600
                   {{ $hasLeftBorder ? 'border-l-0' : '' }}
                   rounded-none block bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:outline-none {{ $class }}">
            <span x-text="selected"></span>
        </button>

        <!-- Options -->
        <ul
            x-show="open"
            x-transition
            class="absolute z-10 mt-1 max-h-48 w-full overflow-auto rounded-md border border-gray-300 bg-white dark:bg-gray-800 text-sm shadow-lg focus:outline-none"
        >
            @foreach ($options as $optionValue => $optionLabel)
                <li
                    @click="choose('{{ $optionValue }}', '{{ $optionLabel }}')"
                    class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-600"
                >
                    {{ $optionLabel }}
                </li>
            @endforeach
        </ul>
    </div>
</td>
