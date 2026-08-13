@php
    // 편집기에서 고른 비율(크롭 이름). 없으면 원본(default).
    $ratio = $block->input('ratio');
    $ratio = is_array($ratio) ? ($ratio[0] ?? 'default') : ($ratio ?: 'default');
    if (! in_array($ratio, ['default', 'square', 'wide', 'hero'], true)) {
        $ratio = 'default';
    }
@endphp
@if($block->hasImage('image', 'default'))
    <figure class="block-full-image block-full-image--{{ $ratio }}">
        @include('site.partials.responsive-image', ['model' => $block, 'role' => 'image', 'crop' => $ratio, 'class' => 'block-full-image__image', 'sizes' => '100vw'])
        @if($blockValue($block, 'caption'))
            <figcaption>{{ $blockValue($block, 'caption') }}</figcaption>
        @endif
    </figure>
@endif
