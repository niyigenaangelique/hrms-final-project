@props([
    'class' => '',
    'width' => 'min-w-[10rem]', // default width
])

<th scope="col"
    class="border border-dashed border-zinc-600 h-8 ps-[1.375rem] {{ $width }} {{ $class }}"
    {{ $attributes }}
>
    {{ $slot }}
</th>
