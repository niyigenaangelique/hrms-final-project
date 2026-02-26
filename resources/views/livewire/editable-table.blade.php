<div>
    <flux:table>
        <flux:table.columns>
            @foreach ($columns as $column => $label)
                <flux:table.column>{{ $label }}</flux:table.column>
            @endforeach
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($items as $index => $item)
                <flux:table.row :key="$item['id']">
                    @foreach ($editableFields as $field => $config)
                        <flux:table.cell>
                            @if (is_array($config) && $config['type'] === 'select')
                                <flux:select
                                    wire:model.debounce.500ms="editingData.{{ $item['id'] }}.{{ $field }}"
                                    wire:blur="handleBlur('{{ $item['id'] }}', {{ $index }})"
                                    wire:keydown.tab="handleKeydown('{{ $item['id'] }}', {{ $loop->index }})"
                                >
                                    <option value="">Select an option</option>
                                    @foreach ($selectOptions[$field] ?? [] as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </flux:select>
                                @error('editingData.' . $item['id'] . '.' . $field)
                                <flux:error :name="'editingData.' . $item['id'] . '.' . $field" />
                                @enderror
                            @else
                                <flux:input
                                    wire:model.debounce.500ms="editingData.{{ $item['id'] }}.{{ $field }}"
                                    wire:blur="handleBlur('{{ $item['id'] }}', {{ $index }})"
                                    wire:keydown.tab="handleKeydown('{{ $item['id'] }}', {{ $loop->index }})"
                                    type="{{ is_array($config) ? $config['type'] : $config }}"
                                />
                                @error('editingData.' . $item['id'] . '.' . $field)
                                <flux:error :name="'editingData.' . $item['id'] . '.' . $field" />
                                @enderror
                            @endif
                        </flux:table.cell>
                    @endforeach
                    <flux:table.cell>
                        <flux:button wire:click="save('{{ $item['id'] }}', {{ $index }})" variant="primary" size="sm">Save</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
