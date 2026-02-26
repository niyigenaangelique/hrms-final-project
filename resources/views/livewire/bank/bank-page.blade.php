<div class="w-fill-available scrollbar-custom">
    <div class="h-screen flex max-md:flex-col !items-start">
        <livewire:bank.list-view wire:debug="bank" />
        <livewire:bank.form-view />
    </div>

    @section('commands')
        <livewire:crud-commands model-type="Bank" />
    @endsection


</div>
{{-- Do your work, then step back. --}}
