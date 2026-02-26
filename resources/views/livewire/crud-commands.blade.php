@php
    use Illuminate\Support\Facades\Route;
@endphp
<flux:command class="relative h-full w-full col-span-2 border border-dashed  bg-primary-200 !rounded-none ">
    <flux:command.items class="!ps-0.5 h-full bg-primary-200">
        <flux:command.item
            class="border border-dashed border-b-gray-600 bg-red-200  !rounded-none"
            wire:click="dispatchClosePage"
            icon="x-circle"
        >
            Close Page
        </flux:command.item>
        <flux:command.item
            class="bg-white border border-dashed border-b-gray-600 !rounded-none"
            wire:click="dispatchNew"
            icon="document-plus">
            New Item
        </flux:command.item>
        <flux:command.item
            class="bg-white border border-dashed border-b-gray-600 !rounded-none"
            wire:click="dispatchCreate"
            icon="save-as">
            Save New Item
        </flux:command.item>
        <flux:command.item
            class="bg-white border border-dashed border-b-gray-600 !rounded-none "
            wire:click="dispatchSave"
            icon="save">
            Update
        </flux:command.item>

        <flux:command.item
            class="bg-white border border-dashed border-b-gray-600 !rounded-none"
            wire:click="dispatchDelete"
            icon="delete">
            Delete
        </flux:command.item>
        {{Route::is('users')}}
        <flux:command.item
            class="bg-white border border-dashed border-b-gray-600 !rounded-none"
            wire:click="dispatchCancel"
            icon="backspace">
            Cancel
        </flux:command.item>

{{--        <x-secure-command-button--}}
{{--            route="*"--}}
{{--            gate="companyAdministrationView"--}}
{{--            click="dispatchNew"--}}
{{--            icon="document-plus"--}}
{{--            label="New Item with test"--}}
{{--            class="bg-white border border-dashed border-b-gray-600 !rounded-none"--}}
{{--        />--}}


        {{--            Quick Actions--}}

        <flux:separator text="Quick Actions" class="mb-4 mt-2.5" variant="subtle"/>

        <flux:command.item
            class="bg-white border border-dashed border-b-gray-600 !rounded-none"
            wire:click="..."
            icon="import-csv">
            Create from CSV
        </flux:command.item>
        <flux:command.item
            class="bg-white border border-dashed border-b-gray-600 !rounded-none"
            wire:click="dispatchExport"
            icon="export-csv">
            Export to CVS
        </flux:command.item>
        <flux:command.item
            class="bg-white border border-dashed border-b-gray-600 !rounded-none"
            wire:click="..."
            icon="export-pdf">
            Export to PDF
        </flux:command.item>

        {{--            Quick Actions--}}
        {{--
         <flux:separator text="Record Actions" class="mb-4 mt-2.5" variant="subtle"/>

         <flux:command.item
             class="bg-white border border-dashed border-b-gray-600 !rounded-none"
             wire:click="..."
             icon="copy">
             Copy
         </flux:command.item>
         <flux:command.item
             class="bg-white border border-dashed border-b-gray-600 !rounded-none"
             wire:click="..."
             icon="archive">
             Archive
         </flux:command.item>
         <flux:command.item
             class="bg-white border border-dashed border-b-gray-600 !rounded-none"
             wire:click="..."
             icon="disabling-file">
             Disabling
         </flux:command.item>
         <flux:command.item
             class="bg-white border border-dashed border-b-gray-600 !rounded-none"
             wire:click="..."
             icon="enable-file">
             Enable
         </flux:command.item>
         <flux:command.item
             class="bg-white  border border-dashed border-b-gray-600 !rounded-none"
             wire:click="..."
             icon="file-property">
             Properties & Approvals
         </flux:command.item>
     --}}
    </flux:command.items>
</flux:command>
