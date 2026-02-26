{{--@dd($this->employees)--}}
<div class="flex-1 px-0 py-4 max-md:pt-6 self-stretch">
    <flux:fieldset class="px-2">
        <flux:legend>Contract</flux:legend>
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <div class="flex flex-wrap justify-between gap-y-1 gap-x-2.5 bg-white">

            <!-- Code -->
            <flux:input  wire:model.live="form.code" label="Contract Code" readonly copyable class="!w-[150px]"/>

            <flux:select variant="listbox"
                         searchable
                         label="Employee"
                         wire:model.live="form.employee_id"
                         class="!w-[300px] !mt-[-2px]"
                         placeholder="Choose Employee...">
                @foreach($employees as $employee)
                    <flux:select.option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->last_name}} ({{$employee->code}})</flux:select.option>
                @endforeach
            </flux:select>

            <!-- position -->
            <flux:select variant="listbox"
                         searchable
                         label="Position"
                         wire:model.live="form.position_id"
                         class="!w-[250px] !mt-[-2px]"
                         placeholder="Choose Position...">
                @foreach($positions as $position)
                    <flux:select.option value="{{$position->id}}">{{$position->name}} </flux:select.option>
                @endforeach
            </flux:select>

            <!-- Remuneration -->
            <flux:input wire:model.live="form.remuneration" label="Remuneration" type="number" step="0.01" min="0" class="!w-[150px]" />

            <!-- Remuneration Type -->
            <flux:select variant="listbox"
                         label="Remuneration Type"
                         wire:model.live="form.remuneration_type"
                         class="!w-[200px] !mt-[-2px]"
                         placeholder="Choose Type...">
                @foreach($remuneration_types as $type)
                    <flux:select.option value="{{$type['key']}}">{{$type['label']}}</flux:select.option>
                @endforeach
            </flux:select>

            <!-- Employee Category -->
            <flux:select variant="listbox"
                         label="Employee Category"
                         wire:model.live="form.employee_category"
                         class="!w-[200px] !mt-[-2px]"
                         placeholder="Choose Category...">
                @foreach($employee_categories as $category)
                    <flux:select.option value="{{$category['key']}}">{{$category['label']}}</flux:select.option>
                @endforeach
            </flux:select>

            <!-- Daily Working Hours -->
            <flux:input wire:model.live="form.daily_working_hours" label="Daily Working Hours" type="number" step="0.5" min="0" max="24" class="!w-[180px]" />

            <!-- start_date -->
            <flux:date-picker-v01
                wire:model.live="form.start_date"
                wire:dirty.class="border-yellow"
                label="Start Date" required
                class="!w-[200px] border border-zinc-200 !border-dashed"/>

            <!-- end_date -->
            <flux:date-picker-v01
                wire:model.live="form.end_date"
                wire:dirty.class="border-yellow"
                label="End Date" required
                class="!w-[200px] border border-zinc-200 !border-dashed"/>

            <!-- Status -->
            <flux:select variant="listbox"
                         label="Contract Status"
                         wire:model.live="form.status"
                         class="!w-[200px] !mt-[-2px]"
                         placeholder="Choose Status...">
                @foreach($contract_status as $status)
                    <flux:select.option value="{{$status['key']}}">{{$status['label']}}</flux:select.option>
                @endforeach
            </flux:select>

        </div>
    </flux:fieldset>


    <flux:modal name="DeleteConfirm" :dismissible="false" class="">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Contract</flux:heading>
                <flux:text class="mt-2">
                    <p>Are you sure you want to delete <span class="font-bold text-emerald-600">
                            {{ $form->code }}
                        </span>?</p>
                    <p>This action is permanent and cannot be undone.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deleteContract" variant="danger">Delete</flux:button>
            </div>
        </div>
    </flux:modal>

</div>


{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
