<div class="bg-gray-400 min-h-screen flex items-center justify-center">
    <div class="flex flex-col items-center justify-center gap-6 w-full max-w-ld px-4">

        @if($result)
            <!-- Validation Results Card -->
            <flux:card class="w-full max-w-md p-6 bg-white rounded-sm shadow-sm">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Validation Results</h2>
                <div class="space-y-4">

                    @foreach (['valid' => 'green', 'invalid' => 'red'] as $type => $color)
                        @php
                            $count = $result["{$type}_count"] ?? 0;
                        @endphp
                        @if ($count)
                            <div class="p-4 bg-{{ $color }}-50 rounded-md border border-{{ $color }}-200 flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-{{ $color }}-800">
                                    @if($type === 'valid')
                                        Valid Items: {{ $count }}
                                    @else
                                        You have imported {{ $count }} invalid contracts
                                    @endif
                                </h3>
                                @if($type === 'valid')
                                    <flux:button
                                        wire:click="saveValidData"
                                        class="px-4 py-2 bg-{{ $color }}-600 text-white rounded-md hover:bg-{{ $color }}-700 transition-colors">
                                        Create Contracts
                                    </flux:button>
                                @endif
                            </div>
                        @endif
                    @endforeach

                </div>
                @if (session()->has('message'))
                    <div class="bg-blue-100 text-blue-800 border border-blue-300 rounded px-4 py-2 my-4">
                        {{ session('message') }}
                    </div>
                @endif
                <!-- Back Button -->
                <div class="mt-6 text-center">
                    <a href="{{ url()->previous() }}"
                       class="inline-block px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                        Back
                    </a>
                </div>
            </flux:card>
        @else
            <!-- Import Form Card -->
            <flux:card class="w-full max-w-2xl p-6 bg-white rounded-sm shadow-sm">
                <h3 class="text-lg px-6 font-semibold text-gray-800">Import Data</h3>
                <div class="w-full p-4">
                    <h4 class="font-medium text-gray-800 mb-2">Contracts data file</h4>
                    <flux:input.group>
                        <flux:input
                            type="file"
                            placeholder="Select File (CSV/XLSX)"
                            wire:model.live="file"
                            class="!h-[2.1rem] col-span-9"
                        />
                        <flux:button
                            icon="document-arrow-up"
                            variant="primary"
                            wire:click="importToArray"
                            wire:loading.attr="disabled"
                            class="!h-[2.1rem]"
                        >
                            <span wire:loading.remove>Import Data</span>
                            <span wire:loading>Processing...</span>
                        </flux:button>
                    </flux:input.group>
                </div>
            </flux:card>
        @endif

    </div>

    @section('commands')
        <livewire:crud-commands model-type="ContractImportData"/>
    @endsection
</div>
