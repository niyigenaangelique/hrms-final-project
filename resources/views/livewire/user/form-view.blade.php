
<div class="flex-1 px-0 py-4 max-md:pt-6 self-stretch">
    <flux:fieldset class="px-2">
        <flux:legend>User</flux:legend>
        @if($errors->any())

        @endif

        <div class="flex flex-wrap justify-between gap-y-1 gap-x-2.5 bg-white">

            <!-- Code -->
            <flux:input
                wire:model.blur="form.code"
                label="Code"
                readonly
                copyable
                class="!w-[200px]"/>
            <!-- first_name -->

            <flux:input
                badge="Required"
                wire:model.blur="form.first_name"
                wire:dirty.class="border-yellow"
                label="First Name"
                required
                class="!w-[300px]"/>
            <!-- middle_name -->

            <flux:input
                wire:model.blur="form.middle_name"
                wire:dirty.class="border-yellow"
                label="Middle Name"
                class="!w-[200px]"/>
            <!-- last_name -->

            <flux:input
                badge="Required"
                wire:model.blur="form.last_name"
                wire:dirty.class="border-yellow"
                label="Last Name"
                required
                class="!w-[300px]"/>


        </div>
    </flux:fieldset>

    <flux:tab.group  class="flex mt-2.5 flex-col flex-1 flex-grow items-start ">
        <flux:tabs class="flex-shrink-0 w-full bg-gray-50">
            <flux:tab name="account" icon="user">Account</flux:tab>
            <flux:tab name="security" icon="shield-check">Security</flux:tab>
        </flux:tabs>

        {{--Account--}}
        <flux:tab.panel name="account" class="flex w-full justify-between pt-2.5 px-2 flex-col flex-1 flex-grow items-start">
            <flux:fieldset class="w-full">

                <div class="flex flex-wrap justify-between gap-y-1 gap-x-2.5 bg-white">
                    <!-- username -->
                    <flux:input
                        badge="Required"
                        wire:model.blur="form.username"
                        wire:dirty.class="border-yellow"
                        label="Username"
                        required
                        class="!w-[200px]"/>

                    <!-- email -->
                    <flux:input
                        badge="Required"
                        wire:model.blur="form.email"
                        wire:dirty.class="border-yellow"
                        label="Email"
                        required
                        class="!w-[300px] overflow-ellipsis"/>

                    <!-- phone_number -->
                    <flux:input
                        badge="Required"
                        wire:model.blur="form.phone_number"
                        wire:dirty.class="border-yellow"
                        label="Phone Number"
                        required
                        class="!max-w-[300px] break-words"/>

                    <!-- Type Selection -->
                    <flux:select :filter="false"
                                 class="!h-8 font-mono !w-[250px] border border-dashed border-zinc-600 border-b-zinc-700/80 rounded-none "
                                 wire:model.live="form.role" label="User Role"
                                 error="{{ $errors->first('form.role') }}" placeholder="Select User role">

                        @foreach ($userRoles as $userRole)
                            {{--                                {{ dd($userRole) }}--}}
                            <flux:select.option
                                value="{{ $userRole['key'] }}">{{ ucwords(str_replace('_', ' ', $userRole['label'])) }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>


            </flux:fieldset>

        </flux:tab.panel>
        {{-- Security--}}
        <flux:tab.panel name="security" class="flex pt-2.5 px-3 flex-col flex-1 flex-grow items-start">
            <flux:fieldset>
                <div class="flex flex-wrap me-2.5  gap-y-1 gap-x-2.5 bg-white">
                    <!-- password -->
                    <flux:input
                        wire:model.blur="form.password"
                        label="Password"
                        type="password"
                        class="!w-[300px]"
                        viewable
                    />

                    <!-- confirm_password -->
                    <flux:input
                        wire:model.blur="form.password_confirmation"
                        label="Confirm Password"
                        type="password"
                        class="!w-[300px]"
                        viewable
                    />


                </div>
                <flux:button
                    wire:click="changePassword()"
                    class="mt-2"
                    type="button"
                    variant="primary"
                    size="sm"
                >
                    Change Password
                </flux:button>
            </flux:fieldset>
        </flux:tab.panel>



    </flux:tab.group>
    <flux:modal name="DeleteConfirm" :dismissible="false" class="">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete User Profile</flux:heading>
                <flux:text class="mt-2">
                    <p>Are you sure you want to delete <span class="font-bold text-emerald-600">
                            {{ $form->first_name }} {{ $form->last_name }}
                        </span>'s profile?</p>
                    <p>This action is permanent and cannot be undone.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deleteUser" variant="danger">Delete User</flux:button>
            </div>
        </div>
    </flux:modal>
    <flux:modal name="NoSelected" :dismissible="true" class="md:w-1/5">
        <div class="space-y-6">
            <flux:heading size="lg">No User Selected</flux:heading>
            <flux:text class="mt-2">
                <p>You must select a User before attempting to delete.</p>
            </flux:text>
            <div class="flex gap-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="primary">OK</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>

</div>
