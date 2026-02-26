<div class="w-fill-available scrollbar-custom">
    <div class="h-screen flex max-md:flex-col !items-start">
        <livewire:payslip_entry.list-view wire:debug="payslipEntry" />
        <livewire:payslip_entry.form-view />
    </div>

    @section('commands')
        <livewire:crud-commands model-type="PayslipEntry" />
    @endsection


</div>
{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
