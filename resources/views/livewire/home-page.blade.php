@php
    $roles = collect(\App\Enum\UserRole::detailedList())
        ->mapWithKeys(function ($item) {
            return [
                $item['key'] instanceof \App\Enum\UserRole ? $item['key']->value : $item['key'] => $item['label']
            ];
        })
        ->toArray();
@endphp
<div class="relative w-full overflow-x-auto shadow-md sm:rounded-lg">

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="relative p-4 m-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm border border-dashed border-zinc-600 text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-200">
            <tr class="">
                <x-table.header-cell>Code</x-table.header-cell>
                <x-table.header-cell>First Name</x-table.header-cell>
                <x-table.header-cell>Middle Name</x-table.header-cell>
                <x-table.header-cell>Last Name</x-table.header-cell>
                <x-table.header-cell>Username</x-table.header-cell>
                <x-table.header-cell>Email</x-table.header-cell>
                <x-table.header-cell>Phone Number</x-table.header-cell>
                <x-table.header-cell>Role</x-table.header-cell>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $index => $user)
                <x-table.row :index="$index" theme="gray-200">
{{--                    date-picker--}}
                    <x-table.input-cell readonly wire:model.defer="users.{{ $index }}.code" name="code"/>
                    <x-table.input-cell wire:model.defer="users.{{ $index }}.first_name" name="first_name"/>
                    <x-table.input-cell wire:model.defer="users.{{ $index }}.middle_name" name="middle_name"/>
{{--                    <x-table.date-picker-cell wire:model.defer="users.{{ $index }}.created_at" name="middle_name" />--}}
                    <x-table.input-cell wire:model.defer="users.{{ $index }}.last_name" name="last_name"/>
                    <x-table.input-cell wire:model.defer="users.{{ $index }}.username" name="username"/>
                    <x-table.input-cell wire:model.defer="users.{{ $index }}.email" name="email"/>
                    <x-table.input-cell wire:model.defer="users.{{ $index }}.phone_number" name="phone_number"/>
                    <x-table.searchable-select-cell
                        :options="$roles"
                        :value="$user['role']"
                        :placeholder="'Select Role'"
                        :hasRightBorder="false"
                        name="role"
                        wire:model.defer="users.{{ $index }}.role"
                    />
                </x-table.row>
            @endforeach
            </tbody>
        </table>
    </div>

    <button wire:click="addEmptyRow" class="mt-4 px-4 py-2 bg-gold-600 text-white rounded hover:bg-blue-700">
        Add User
    </button>
    <button wire:click="saveData" class="mt-4 px-4 py-2 bg-gold-600 text-white rounded hover:bg-blue-700">
        Save data
    </button>
</div>

@script
<script>
    $wire.on('log-to-console', ({message}) => {
        console.log(message); // Direct destructuring
    });
</script>
@endscript

