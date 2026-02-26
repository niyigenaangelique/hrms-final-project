
<div class="flex-1 px-0 py-4 max-md:pt-6 self-stretch">
    <flux:fieldset class="px-2">
        <flux:legend>Project</flux:legend>
        @if($errors->any())

        @endif

        <div class="flex flex-wrap justify-between gap-y-1 py-2.5 gap-x-2.5 bg-white">

            <!-- Code -->
            <flux:input  wire:model.blur="form.code" label="Code" readonly copyable class="!w-[200px]"/>

            <!-- name -->
            <flux:input badge="Required" wire:model.blur="form.name" wire:dirty.class="border-yellow" label="Project Name" required class="!w-[500px]"/>
            <!-- start_date -->

            <flux:date-picker wire:model="form.start_date" wire:dirty.class="border-yellow" label="Project Start Date" class="!w-[150px]" with-today selectable-header start-day="1" week-numbers/>

            <!-- end_date -->
            <flux:date-picker wire:model="form.end_date" wire:dirty.class="border-yellow" label="Project End Date" class="!w-[150px]" with-today selectable-header start-day="1" week-numbers/>



        </div>

        <flux:radio.group wire:model="form.status" label="Project Status" variant="pills">
            @foreach ($project_statuses as $projectStatus)
                <flux:radio value="{{ $projectStatus['key'] }}" label="{{ $projectStatus['label'] }}" />
            @endforeach

        </flux:radio.group>
        <!-- description -->
        <flux:editor wire:model="form.description" wire:dirty.class="border-yellow" label="Description" class="!w-full" toolbar="heading | bold italic underline | align | ~ undo redo" />

        <!-- address -->
        <flux:textarea rows="2" wire:model="form.address" wire:dirty.class="border-yellow" label="Project address" class="!w-full" />

        <div class="flex w-full justify-between flex-wrap gap-y-1 gap-x-2.5 bg-white">
            <div class="flex w-full justify-between flex-wrap gap-y-1 gap-x-2.5 bg-white">
                <!-- country -->
                <flux:input badge="Required" wire:model.blur="form.country" wire:dirty.class="border-yellow" label="Country" required class="!w-[300px] overflow-ellipsis"/>
                <!-- state -->
                <flux:input
                    badge="Required" wire:model.blur="form.state" wire:dirty.class="border-yellow" label="State" required class="!w-[300px] overflow-ellipsis"/>
                <!-- city -->
                <flux:input badge="Required" wire:model.blur="form.city" wire:dirty.class="border-yellow" label="City" required class="!w-[300px] overflow-ellipsis"/>

            </div>
        </div>


        <div class="flex w-full mb-4 flex-wrap gap-y-1 my-4 gap-x-2.5 bg-black/10">
            <div class="flex w-full flex-wrap gap-y-1 gap-x-2.5 bg-white">
                @if ($form->project && $form->project->manager)
                    @php $manager = $form->project->manager; @endphp

                    <div class="flex items-center bg-black/10  p-4 w-full justify-between">
                        <div class="flex items-center">
                            <img src="{{ asset('images/user.svg') }}"
                                 alt="User Avatar"
                                 class="w-24 h-24 rounded-sm object-cover mr-6 border"/>

                            <div>
                                <flux:heading size="lg" class="text-lg font-semibold mb-2">Project Manager Profile</flux:heading>

                                <h5 class="text-base font-semibold text-gray-800">{{ $manager->last_name }} {{ $manager->first_name }} ({{ $manager->code }})</h5>
                                <p class="text-sm text-gray-600">{{ $manager->email }}</p>
                                <p class="text-sm text-gray-600">{{ $manager->phone_number }}</p>

                            </div>
                        </div>

                        <flux:button
                            icon="pencil-square"
                            variant="filled"
                            class="h-10"
                            wire:click="">
                            Change Manager
                        </flux:button>
                    </div>
                @else
                    <div class="flex items-center justify-between bg-black/10 p-4  w-full">
                        <div>
                            <flux:heading size="lg" class="text-lg font-semibold mb-2">Project Manager Profile</flux:heading>
                            <p class="text-sm text-gray-500">No manager assigned to this project.</p>
                        </div>

                        <flux:button
                            icon="user-plus"
                            variant="primary"
                            class="h-10"
                            wire:click="">
                            Set Manager
                        </flux:button>
                    </div>
                @endif


            </div>
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
                <flux:button wire:click="deleteProject" variant="danger">Delete</flux:button>
            </div>
        </div>
    </flux:modal>

</div>


{{-- Care about people's approval and you will be their prisoner. --}}
