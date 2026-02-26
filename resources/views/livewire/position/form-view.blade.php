
<div class="flex-1 px-0 py-4 max-md:pt-6 self-stretch">
    <flux:fieldset class="px-2">
        <flux:legend>Position</flux:legend>
        @if($errors->any())

        @endif

        <div class="flex flex-wrap justify-between gap-y-1 gap-x-2.5 bg-white">

            <!-- Code -->
            <flux:input  wire:model.live="form.code" label="Code" readonly copyable class="!w-[200px]"/>

            <!-- name -->
            <flux:input badge="Required" wire:model.live="form.name" wire:dirty.class="border-yellow" label="Position Name" required class="!w-[400px]"/>
            <!-- minimum pay -->
            <flux:input badge="Required" wire:model.live="form.minimum_pay_string" wire:dirty.class="border-yellow" label="Minimum Salary"
                        x-on:input="$event.target.value = ($event.target.value.replace(/[^0-9.]/g, '')).replace(/(\..*)\./g, '$1')"
                        x-on:focus="$event.target.value = ($event.target.value.replace(/[^0-9.]/g, '')).replace(/(\..*)\./g, '$1')"
                        required class="!w-[200px]"/>
            <!-- maximum pay -->
            <flux:input  badge="Required" wire:model.live="form.maximum_pay_string" wire:dirty.class="border-yellow" label="Maximum Salary"
                         x-on:input="$event.target.value = ($event.target.value.replace(/[^0-9.]/g, '')).replace(/(\..*)\./g, '$1')"
                         x-on:focus="$event.target.value = ($event.target.value.replace(/[^0-9.]/g, '')).replace(/(\..*)\./g, '$1')"
                         required class="!w-[200px]"/>


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
                <flux:button wire:click="deletePosition" variant="danger">Delete</flux:button>
            </div>
        </div>
    </flux:modal>

</div>


{{-- In work, do what you enjoy. --}}
