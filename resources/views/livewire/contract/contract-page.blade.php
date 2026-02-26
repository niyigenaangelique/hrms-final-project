<div class="w-fill-available scrollbar-custom">
    <div class="h-screen flex max-md:flex-col !items-start">
        <livewire:contract.list-view wire:debug="contract" />
        <livewire:contract.form-view />
    </div>

    @section('commands')
        <livewire:crud-commands model-type="Contract" />
    @endsection


</div>
{{-- Stop trying to control. --}}
