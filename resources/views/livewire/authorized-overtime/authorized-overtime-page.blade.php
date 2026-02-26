<div class="w-fill-available scrollbar-custom">
    <div class="h-screen flex max-md:flex-col !items-start">
        <livewire:authorized_overtime.list-view wire:debug="authorizedOvertime" />
        <livewire:authorized_overtime.form-view />
    </div>

    @section('commands')
        <livewire:crud-commands model-type="AuthorizedOvertime" />
    @endsection


</div>
{{-- The best athlete wants his opponent at his best. --}}
