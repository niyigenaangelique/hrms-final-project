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
<svg {{ $attributes->class($classes) }} data-flux-icon aria-hidden="true"  viewBox="0 0 26 26" width="24" height="24">
    <path d="M18 9L15 9L15 2L18 2 Z M 26 6L26 23C26 24.65625 24.65625 26 23 26L3 26C1.34375 26 0 24.65625 0 23L0 3C0 1.34375 1.34375 0 3 0L20 0C20.828125 0 21.285156 0.0429688 23.621094 2.378906C25.957031 4.714844 26 5.171875 26 6 Z M 5 9C5 9.550781 5.449219 10 6 10L19 10C19.550781 10 20 9.550781 20 9L20 2C20 1.449219 19.550781 1 19 1L6 1C5.449219 1 5 1.449219 5 2 Z M 23 14C23 13.449219 22.550781 13 22 13L4 13C3.449219 13 3 13.449219 3 14L3 24C3 24.550781 3.449219 25 4 25L22 25C22.550781 25 23 24.550781 23 24Z" fill="#5B5B5B" />
</svg>
