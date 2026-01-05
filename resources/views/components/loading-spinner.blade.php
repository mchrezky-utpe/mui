@props([
    'target' => '',         // Livewire method target, string atau CSV
    'text' => 'Loading...', // default text
    'size' => '6',          // default svg size (tailwind w-6 h-6)
    'class' => '',           // tambahan class custom
    'svg_class' => ''       // tambahan class custom svg
])

<div
    wire:loading
    @if($target) wire:target="{{ $target }}" @endif
    class="tw-flex tw-items-center tw-gap-2 {{ $class }}"
>
    <svg
        {{ $attributes->merge(['class' => "tw-w-{$size} tw-h-{$size} tw-animate-spin tw-text-gray-500 {$svg_class}"]) }}
        viewBox="0 0 24 24"
        fill="none"
    >
        <circle
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
            class="tw-opacity-25"
        />
        <path
            d="M4 12a8 8 0 018-8"
            stroke="currentColor"
            stroke-width="4"
            class="tw-opacity-75"
        />
    </svg>
    <span class="tw-text-gray-500 tw-font-medium">{{ $text }}</span>
</div>
