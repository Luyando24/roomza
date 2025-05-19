@props(['rating', 'size' => 'md'])

@php
    $sizes = [
        'sm' => 'text-sm',
        'md' => 'text-xl',
        'lg' => 'text-2xl',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => "flex items-center text-yellow-400 {$sizeClass}"]) }}>
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $rating)
            <span>★</span>
        @else
            <span>☆</span>
        @endif
    @endfor
</div>