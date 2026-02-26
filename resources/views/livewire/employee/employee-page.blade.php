<div class="w-fill-available scrollbar-custom">
    <div class="h-screen flex max-md:flex-col !items-start">
        <livewire:employee.list-view wire:debug="employee" />
        <livewire:employee.form-view />
    </div>

    @section('commands')
        <livewire:crud-commands model-type="Employee" />
    @endsection


</div>
{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
