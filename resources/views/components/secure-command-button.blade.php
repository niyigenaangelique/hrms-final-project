@props(['route', 'gate', 'click', 'icon', 'label', 'class'])

@if (Gate::check($gate, auth()->user()) && request()->routeIs($route))
    <flux:command.item
        {{ $attributes->merge(['class' => $class]) }}
        wire:click="{{ $click }}"
        icon="{{ $icon }}">
        {{ $label }}
    </flux:command.item>
@endif
