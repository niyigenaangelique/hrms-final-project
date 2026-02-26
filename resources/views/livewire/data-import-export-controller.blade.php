<div class="w-fill-available scrollbar-custom">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Import/Export</h2>

    <div class="space-y-4 border rounded-lg p-6 bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-800">Import Data</h3>

        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-3">
                <div class="bg-white p-4 rounded shadow-inner">
                    <h4 class="font-medium text-gray-800 mb-2">Choose Template </h4>

                    <flux:select
                        class="!h-10"
                        wire:model.live="selectedTemplate" variant="combobox" :filter="true">
                        @foreach ($templates as $key => $template)
                            <flux:select.option value="{{ $key }}" wire:key="{{ $key }}">
                                {{ $template['title'] }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:button
                        icon="document-arrow-down"
                        variant="primary"
                        wire:click="downloadTemplateCSV('{{ $selectedTemplate }}')"
                    >{{ $templates[$selectedTemplate]['title'] }} Template</flux:button>
                </div>
            </div>
            @if($selectedTemplate)
                <div class="col-span-6">
                    <div class="bg-white p-4 rounded shadow-inner">
                        <h4 class="font-medium text-gray-800 mb-2">Template Fields</h4>

                        @foreach($templates[$selectedTemplate]['field_map'] as $field => $label)
                            <flux:badge variant="solid" color="zinc" class="mb-2">
                                {{ $field }}</span> ({{ $label }})
                            </flux:badge>

                        @endforeach

                        @if(!empty($templates[$selectedTemplate]['fixed_fields']))

                            <div class="mt-3">
                                <h4 class="font-medium text-gray-800 mb-1">Fixed Values:</h4>
                                @foreach($templates[$selectedTemplate]['fixed_fields'] as $field => $value)
                                    <flux:badge variant="pill" class="mb-2" color="teal"> {{ $field }}: {{ is_bool($value) ? ($value ? 'true' : 'false') : $value }}</flux:badge>
                                @endforeach

                            </div>
                        @endif

                    </div>

                </div>

                <div class="col-span-3">
                    <div class="bg-white p-4 rounded shadow-inner">
                        <h4 class="font-medium text-gray-800 mb-2">Choose Template </h4>
                        <flux:input type="file" placeholder="Select File  (CSV/XLSX)" wire:model.live="file" class="!mb-2"/>
                        <flux:button
                            icon="document-arrow-up"
                            variant="primary"
                            wire:click="import" wire:loading.attr="disabled" >

                            <span wire:loading.remove>Import {{ $templates[$selectedTemplate]['title'] }}</span>
                            <span wire:loading>Processing...</span>
                        </flux:button>
                    </div>
                </div>
            @endif
        </div>

        @error('selectedTemplate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
</div>


</div>
{{-- In work, do what you enjoy. --}}
