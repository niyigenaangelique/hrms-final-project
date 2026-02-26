
<div class="flex-1 px-0 py-4 max-md:pt-6 self-stretch">
    <flux:fieldset class="px-2">
        <flux:legend>Device</flux:legend>
        @if($errors->any())

        @endif

        <div class="flex flex-wrap justify-between gap-y-1 gap-x-2.5 bg-white">

            <!-- Code -->
            <flux:input  wire:model.blur="form.code" label="Code" readonly copyable class="!w-[200px]"/>
            <!-- - project_id -->
            <flux:select  variant="listbox" clearable placeholder="Select Project" searchable badge="Required" wire:model.live="form.project_id" wire:dirty.class="border-yellow" label="Project " required class="!w-[300px] overflow-ellipsis">
                @foreach ($projects as $project)
                    <flux:select.option value="{{ $project->id }}">{{ $project->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <!-- name -->
            <flux:input badge="Required" wire:model.blur="form.name" wire:dirty.class="border-yellow" label="Device Name" required class="!w-[500px]"/>

            <!-- model -->
            <flux:input badge="Required" wire:model.blur="form.model" wire:dirty.class="border-yellow" label="Device Model" required class="!w-[300px]"/>

            <!-- ip_address -->
            <flux:input wire:model.blur="form.ip_address" wire:dirty.class="border-yellow" label="IP Address" required class="!w-[200px]"/>

            <!-- serial_number -->
            <flux:input badge="Required" wire:model.blur="form.serial_number" wire:dirty.class="border-yellow" label="Serial Number" required class="!w-[200px]"/>

            <!-- mac_address -->
            <flux:input badge="Required" wire:model.blur="form.mac_address" wire:dirty.class="border-yellow" label="MAC Address" required class="!w-[300px]"/>

            <!-- location -->
            <flux:input badge="Required" wire:model.blur="form.location" wire:dirty.class="border-yellow" label="Location" required class="!w-[300px]"/>


        </div>
        <!-- description -->
        <flux:editor wire:model="form.description" wire:dirty.class="border-yellow" label="Description" class="!w-full" toolbar="heading | bold italic underline | align | ~ undo redo" />

    </flux:fieldset>


    <flux:modal name="DeleteConfirm" :dismissible="false" class="">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete User Profile</flux:heading>
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
                <flux:button wire:click="deleteDevice" variant="danger">Delete</flux:button>
            </div>
        </div>
    </flux:modal>

</div>


{{-- Be like water. --}}
