<div class="w-fill-available scrollbar-custom">
    <div class="h-screen flex max-md:flex-col !items-start">
        <livewire:attendance.list-view wire:debug="attendance" />
        <livewire:attendance.form-view />
    </div>

    @section('commands')
        <livewire:crud-commands model-type="Attendance" />
    @endsection


</div>
{{-- Care about people's approval and you will be their prisoner. --}}
