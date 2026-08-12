@props(['variant' => 'cta', 'href' => null, 'disabled' => false])

@php($tag = $href && !$disabled ? 'a' : 'button')

<{{ $tag }}
    {{ $attributes->class(['btn', 'btn--' . $variant]) }}
    @if($tag === 'a') href="{{ $href }}" @else type="{{ $attributes->get('type', 'button') }}" @endif
    @if($disabled) @if($tag === 'a') aria-disabled="true" @else disabled @endif @endif
>{{ $slot }}</{{ $tag }}>
