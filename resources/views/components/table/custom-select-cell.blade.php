@props([
    'options' => [],
    'placeholder' => 'Select...',
    'model' => null,
    'hasLeftBorder' => false,
    'class' => '',
])

<th
    scope="col"
    class="border border-dashed border-zinc-600 h-8 ps-[1.375rem] {{ $hasLeftBorder ? 'border-l-0' : '' }}"
>
    <div
        x-data="{
            open: false,
            selectedLabel: '',
            options: {{ json_encode($options) }},
            model: @entangle($attributes->wire('model')),
            toggle() { this.open = !this.open },
            close() { this.open = false },
            select(value) {
                this.model = value;
                this.updateLabel();
                this.close();
            },
            updateLabel() {
                this.selectedLabel = this.options[this.model] || '';
            },
            init() {
                this.updateLabel();
            }
        }"
        x-init="init()"
        class="relative w-full"
    >
        <button
            x-ref="trigger"
            @click="toggle"
            type="button"
            class="w-full bg-white border border-gray-300 rounded text-sm px-2 py-1 text-left cursor-pointer flex items-center justify-between {{ $class }}"
        >
            <span x-text="selectedLabel || '{{ $placeholder }}'" class="truncate text-gray-700"></span>
            <svg class="w-4 h-4 text-gray-500 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div
            x-show="open"
            x-transition
            @click.outside="close"
            class="absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded shadow max-h-60 overflow-auto text-sm"
            style="display: none;"
        >
            <template x-for="(label, value) in options" :key="value">
                <div
                    @click="select(value)"
                    class="cursor-pointer px-3 py-2 hover:bg-blue-100"
                    :class="{ 'bg-blue-50 font-medium': model === value }"
                    x-text="label"
                ></div>
            </template>
        </div>
    </div>
</th>
