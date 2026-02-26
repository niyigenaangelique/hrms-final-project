@props([
    'index' => null, // Required: Row index for unique ID and styling
    'class' => '', // Optional: Additional CSS classes
    'theme' => 'gray-200', // Color class (e.g., gray-200, blue-400)
    'hover' => 'hover:bg-blue-50 dark:hover:bg-gray-500', // Default hover styles
    'border' => 'border-b border-gray-200 dark:border-gray-700', // Default border styles
    'error' => false, // Boolean or array: Indicates if row has validation errors
])

@php
    // Derive light and dark background classes from theme
    $lightBg = "bg-{$theme}";
    $darkTheme = str_contains($theme, '-') ? explode('-', $theme)[0] . '-700' : 'gray-700';
    $darkBg = "dark:bg-{$darkTheme}";

    // Determine alternating background based on index
    $rowBackground = $index % 2 === 0 ? 'bg-white dark:bg-gray-600':"bg-". $theme;

    // Convert error to array for consistent handling
    $errorClasses = is_array($error) && !empty($error) ? 'border-red-500 bg-red-50 dark:bg-red-900/50' : ($error ? 'border-red-500 bg-red-50 dark:bg-red-900/50' : '');
@endphp

<tr

    id="user-row-{{ $index }}"
    tabindex="{{ $index + 1 }}"
    {{ $attributes }}
    class="{{ $rowBackground }} {{ $border }} {{ $hover }} transition-colors duration-150 {{ $errorClasses }} {{ $class }}"
    aria-label="User row {{ $index + 1 }}"
    {{ $attributes->merge(['x-data' => "{ rowIndex: {$index} }"]) }}
>
    {{ $slot }}
</tr>
