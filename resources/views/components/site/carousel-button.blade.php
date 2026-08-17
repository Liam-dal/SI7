@props(['direction' => 'next', 'carousel' => 'main'])

@php
    $isPrev = $direction === 'previous';
    $label = $isPrev ? '이전' : '다음';
    $path = $isPrev ? 'm15 6l-6 6l6 6' : 'm9 18l6-6l-6-6';
@endphp

<button {{ $attributes->class('btn-icon') }} type="button" data-carousel="{{ $carousel }}" data-direction="{{ $direction }}" aria-label="{{ $label }}">
    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" aria-hidden="true">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $path }}"/>
    </svg>
</button>
