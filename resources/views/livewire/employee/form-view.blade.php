
<div class="flex-1 px-0 py-4 max-md:pt-6 self-stretch">
    <flux:fieldset class="px-2">
        <flux:legend>Employee</flux:legend>
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Validation Errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-wrap justify-between gap-y-1 gap-x-2.5 bg-white">

            <!-- Code -->
            <flux:input  wire:model.blur="form.code" label="Code" readonly copyable class="!w-[200px]"/>

            <!-- first_name -->
            <flux:input badge="Required" wire:model.blur="form.first_name" wire:dirty.class="border-yellow" label="First Name" required class="!w-[300px]"/>
            @error('form.first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <!-- middle_name -->
            <flux:input wire:model.blur="form.middle_name" label="Middle Name" class="!w-[200px]"/>

            <!-- last_name -->
            <flux:input badge="Required" wire:model.blur="form.last_name" wire:dirty.class="border-yellow" label="Last Name" required class="!w-[300px]"/>
            @error('form.last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <!-- gender -->
            <flux:select wire:model.blur="form.gender" label="Gender" class="!w-[200px]">
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </flux:select>
            @error('form.gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <!-- birth_date -->
            <flux:date-picker selectable-header wire:model="form.birth_date" label="Birth Date" class="!w-[200px]"/>

            <!-- nationality -->
            <flux:input wire:model.blur="form.nationality" label="Nationality" class="!w-[300px]"/>

            <!-- national_id -->
            <flux:input wire:model.blur="form.national_id" label="National ID" class="!w-[300px]"/>

            <!-- passport_number -->
            <flux:input wire:model.blur="form.passport_number" label="Passport Number" class="!w-[300px]"/>

            <!-- rss_number -->
            <flux:input wire:model.blur="form.rss_number" label="RSS Number" class="!w-[200px]"/>

            <!-- join_date -->
            <flux:date-picker selectable-header with-today wire:model="form.join_date" label="Join Date" class="!w-[200px]"/>
            @error('form.join_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <!-- phone_number -->
            <flux:input wire:model.blur="form.phone_number" label="Phone Number" class="!w-[300px]"/>

            <!-- email -->
            <flux:input type="email" wire:model.blur="form.email" label="Email" class="!w-[300px]"/>

            <!-- city -->
            <flux:input wire:model.blur="form.city" label="City" class="!w-[200px]"/>

            <!-- state -->
            <flux:input wire:model.blur="form.state" label="State" class="!w-[200px]"/>

            <!-- country -->
            <flux:input wire:model.blur="form.country" label="Country" class="!w-[300px]"/>

        </div>
        <!-- address -->
        <flux:textarea rows="4" wire:model="form.address" wire:dirty.class="border-yellow" label="Employee address" class="!w-full" />

        <!-- Salary Information Section -->
        <flux:fieldset class="mt-6 px-2">
            <flux:legend>Salary Information</flux:legend>
            <div class="flex flex-wrap justify-between gap-y-1 gap-x-2.5 bg-white">
                
                <!-- basic_salary -->
                <flux:input type="number" step="0.01" wire:model.blur="form.basic_salary" wire:dirty.class="border-yellow" label="Basic Salary (RWF)" class="!w-[200px]"/>

                <!-- salary_currency -->
                <flux:select wire:model.blur="form.salary_currency" label="Currency" class="!w-[150px]">
                    <option value="RWF">RWF</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                </flux:select>

                <!-- payment_method -->
                <flux:select wire:model.blur="form.payment_method" label="Payment Method" class="!w-[200px]">
                    <option value="bank">Bank Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="mobile_money">Mobile Money</option>
                </flux:select>

                <!-- bank_name -->
                <flux:select wire:model.blur="form.bank_name" wire:dirty.class="border-yellow" label="Bank Name" class="!w-[200px]">
                    <option value="">Select Bank</option>
                    @foreach($banks as $bank)
                        <option value="{{ $bank->name }}">{{ $bank->name }} ({{ $bank->code }})</option>
                    @endforeach
                </flux:select>

                <!-- bank_account_number -->
                <flux:input wire:model.blur="form.bank_account_number" wire:dirty.class="border-yellow" label="Account Number" class="!w-[200px]"/>

                <!-- bank_branch -->
                <flux:input wire:model.blur="form.bank_branch" wire:dirty.class="border-yellow" label="Bank Branch" class="!w-[200px]"/>

                <!-- mobile_money_provider -->
                <flux:select wire:model.blur="form.mobile_money_provider" label="Mobile Money Provider" class="!w-[200px]">
                    <option value="">Select Provider</option>
                    <option value="mtn">MTN Mobile Money</option>
                    <option value="airtel">Airtel Money</option>
                    <option value="tigocash">Tigo Cash</option>
                </flux:select>

                <!-- mobile_money_number -->
                <flux:input wire:model.blur="form.mobile_money_number" wire:dirty.class="border-yellow" label="Mobile Money Number" class="!w-[200px]"/>

                <!-- salary_effective_date -->
                <flux:date-picker selectable-header wire:model="form.salary_effective_date" label="Salary Effective Date" class="!w-[200px]"/>

                <!-- rssb_rate -->
                <flux:input type="number" step="0.01" wire:model.blur="form.rssb_rate" wire:dirty.class="border-yellow" label="RSSB Rate (%)" class="!w-[150px]" placeholder="3.00"/>

                <!-- pension_rate -->
                <flux:input type="number" step="0.01" wire:model.blur="form.pension_rate" wire:dirty.class="border-yellow" label="Pension Rate (%)" class="!w-[150px]" placeholder="5.00"/>

                <!-- is_taxable -->
                <flux:checkbox wire:model="form.is_taxable" label="Subject to PAYE Tax" class="!w-[200px]"/>

            </div>
        </flux:fieldset>

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
                <flux:button wire:click="deleteEmployee" variant="danger">Delete</flux:button>
            </div>
        </div>
    </flux:modal>

</div>


{{-- The whole world belongs to you. --}}
