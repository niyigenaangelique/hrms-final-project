<div class="w-fill-available scrollbar-custom">
    <div class="h-screen flex max-md:flex-col !items-start">
        <livewire:user.list-view wire:debug="user" />
        <livewire:user.form-view />
    </div>

    @section('commands')
        <livewire:crud-commands model-type="User" />
    @endsection


</div>
{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
