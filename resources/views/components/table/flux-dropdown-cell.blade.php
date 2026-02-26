@props([
    'items' => [],
    'placeholder' => 'Choose an action',
    'triggerIcon' => 'chevron-down',
    'modalName' => null,
    'hasLeftBorder' => false,
])

@php
    $id = $modalName ?? 'flux_dropdown_' . Str::random(6);
@endphp

<td class="border border-dashed border-zinc-600 h-8 ps-[1.375rem] {{ $hasLeftBorder ? 'border-l-0' : '' }}">
    <div class="w-full relative">
        {{-- Trigger --}}
        <flux:modal.trigger name="{{ $id }}">
            <button type="button" class="w-full flex items-center justify-between px-3 py-1 text-sm bg-white border rounded text-gray-700">
                <span>{{ $placeholder }}</span>
                <x-icon name="{{ $triggerIcon }}" class="w-4 h-4 text-gray-500" />
            </button>
        </flux:modal.trigger>

        {{-- Dropdown Modal --}}
        <flux:modal name="{{ $id }}" variant="bare" class="w-full max-w-[30rem] my-[12vh] max-h-screen overflow-y-hidden">
            <flux:command class="border-none shadow-lg inline-flex flex-col max-h-[76vh]">
                <flux:command.input placeholder="Search..." closable />

                <flux:command.items>
                    @foreach ($items as $item)
                        @php
                            $attrs = [
                                'wire:click' => $item['action'] ?? '',
                                'icon' => $item['icon'] ?? '',
                            ];

                            if (!empty($item['kbd'])) {
                                $attrs['kbd'] = $item['kbd'];
                            }
                        @endphp

                        <flux:command.item {{ $attributes->merge($attrs) }}>
                            {{ $item['label'] }}
                        </flux:command.item>
                    @endforeach
                </flux:command.items>
            </flux:command>
        </flux:modal>
    </div>
</td>
