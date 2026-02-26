<div class="w-fill-available scrollbar-custom">
    <div class="h-screen flex max-md:flex-col !items-start">
        <livewire:project.list-view wire:debug="project" />
        <livewire:project.form-view />
    </div>

    @section('commands')
        <livewire:crud-commands model-type="Project" />
    @endsection


</div>
{{-- Do your work, then step back. --}}
