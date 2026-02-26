@php
    $attributes = $unescapedForwardedAttributes ?? $attributes;
@endphp

@props([
    'variant' => 'outline', // Default value for 'variant'
])

@php
    // Adding dynamic classes based on the 'variant' passed to the component
    $classes = Flux::classes('shrink-0')
        ->add(match($variant) {
            'outline' => '[:where(&)]:size-6', // When variant is 'outline'
            'solid' => '[:where(&)]:size-6',  // When variant is 'solid'
            'mini' => '[:where(&)]:size-5',   // When variant is 'mini'
            'micro' => '[:where(&)]:size-4',  // When variant is 'micro'
        });
@endphp

{{-- SVG code starts here --}}
<svg {{ $attributes->class($classes) }} data-flux-icon aria-hidden="true" viewBox="0 0 32 32" width="24" height="24">
    <path d="M13.59375 4L13.28125 4.28125L12.5625 5L6 5L6 7L7 7L7 25C7 26.644531 8.355469 28 10 28L22 28C23.644531 28 25 26.644531 25 25L25 7L26 7L26 5L19.4375 5L18.71875 4.28125L18.40625 4 Z M 14.4375 6L17.5625 6L18.28125 6.71875L18.59375 7L23 7L23 25C23 25.554688 22.554688 26 22 26L10 26C9.445313 26 9 25.554688 9 25L9 7L13.40625 7L13.71875 6.71875 Z M 11 11L11 22L13 22L13 11 Z M 15 11L15 22L17 22L17 11 Z M 19 11L19 22L21 22L21 11Z" fill="#5B5B5B" />
</svg>
