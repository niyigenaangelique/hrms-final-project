<div class="w-fill-available scrollbar-custom">
    <div class="h-screen flex max-md:flex-col !items-start">
        <livewire:device.list-view wire:debug="device" />
        <livewire:device.form-view />
    </div>

    @section('commands')
        <livewire:crud-commands model-type="Device" />
    @endsection


</div>
{{-- The whole world belongs to you. --}}
