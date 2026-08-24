@php
    // 편집기에서 고른 비율(크롭 이름). 없으면 원본(default).
    $ratio = $block->input('ratio');
    $ratio = is_array($ratio) ? ($ratio[0] ?? 'default') : ($ratio ?: 'default');
    if (! in_array($ratio, ['default', 'square', 'wide', 'hero'], true)) {
        $ratio = 'default';
    }

    // 프레임 옵션 — safari 면 이미지를 브라우저 창 목업 안에 넣는다.
    // 이 필드가 생기기 전에 저장된 블록은 값이 없으므로 프레임 없음으로 떨어진다.
    $frame = $block->input('frame');
    $frame = is_array($frame) ? ($frame[0] ?? 'none') : ($frame ?: 'none');
    $frameUrl = trim((string) $block->input('frame_url'));

    $caption = $blockValue($block, 'caption');
@endphp

@if($block->hasImage('image', 'default'))
    <figure class="block-full-image block-full-image--{{ $ratio }} @if($frame === 'safari') block-full-image--framed @endif">
        @if($frame === 'safari')
            {{-- 목업 화면 자리에 실제 <img> 를 넣는다 — SVG <image> 와 달리 srcset 이 살아 있다. --}}
            <x-site.safari-mockup :url="$frameUrl" :alt="$block->imageAltText('image') ?: ($caption ?: 'Browser preview')">
                @include('site.partials.responsive-image', ['model' => $block, 'role' => 'image', 'crop' => $ratio, 'class' => 'block-full-image__image', 'sizes' => '100vw'])
            </x-site.safari-mockup>
        @else
            @include('site.partials.responsive-image', ['model' => $block, 'role' => 'image', 'crop' => $ratio, 'class' => 'block-full-image__image', 'sizes' => '100vw'])
        @endif

        @if($caption)
            <figcaption>{{ $caption }}</figcaption>
        @endif
    </figure>
@endif
