
<div class="flex-1 px-0 py-4 max-md:pt-6 self-stretch">
    <flux:fieldset class="px-2">
        <flux:legend>Bank</flux:legend>
        @if($errors->any())

        @endif

        <div class="flex flex-wrap justify-between gap-y-1 gap-x-2.5 bg-white">

            <!-- Code -->
            <flux:input  wire:model.blur="form.code" label="Code" readonly copyable class="!w-[200px]"/>

            <!-- name -->
            <flux:input badge="Required" wire:model.blur="form.name" wire:dirty.class="border-yellow" label="Bank Name" required class="!w-[300px]"/>

            <!-- city -->
            <flux:input badge="Required" wire:model.blur="form.city" wire:dirty.class="border-yellow" label="City" required class="!w-[150px]"/>

            <!-- country -->
            <flux:input badge="Required" wire:model.blur="form.country" wire:dirty.class="border-yellow" label="Country" required class="!w-[200px]"/>

            <!-- swift code -->
            <flux:input badge="Required" wire:model.blur="form.swift_code" wire:dirty.class="border-yellow" label="Swift Code" required class="!w-[150px]"/>

        </div>
    </flux:fieldset>


    <flux:modal name="DeleteConfirm" :dismissible="false" class="">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete User Profile</flux:heading>
                <flux:text class="mt-2">
                    <p>Are you sure you want to delete <span class="font-bold text-emerald-600">
                            {{ $form->name }}
                        </span>?</p>
                    <p>This action is permanent and cannot be undone.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deleteBank" variant="danger">Delete</flux:button>
            </div>
        </div>
    </flux:modal>

</div>


{{-- Stop trying to control. --}}
