{{-- 프로젝트 본문 이미지 그리드 (fixed·flexible 공용).
     비율(크롭)·표시방식(crop/fit)·배경색·칼럼·라이트박스 로직을 한 곳에서 처리. --}}
@props(['block', 'variant' => 'fixed'])

@php
    $isFlex = $variant === 'flexible';
    $base = $isFlex ? 'block-flex-gallery' : 'block-gallery';
    $defaultRatio = $isFlex ? 'default' : 'square';

    $ratio = $block->input('ratio');
    $ratio = is_array($ratio) ? ($ratio[0] ?? $defaultRatio) : ($ratio ?: $defaultRatio);
    if (! in_array($ratio, ['default', 'square', 'landscape', 'portrait'], true)) {
        $ratio = $defaultRatio;
    }

    // 기존(크롭 없이 올린) 이미지는 해당 크롭 레코드가 없을 수 있으니 default 로 폴백.
    $crop = ($ratio !== 'default' && $block->hasImage('images', $ratio)) ? $ratio : 'default';

    $fit = $block->input('fit_mode') === 'fit' ? 'fit' : 'crop';
    $bg = $block->input('bg_color');

    // Fit: 원본(비크롭)을 박스에 contain → 전체가 보이고 여백은 배경색. Crop: 비율 크롭으로 채움.
    $imgCrop = $fit === 'fit' ? 'default' : $crop;
    $display = $block->images('images', $imgCrop, ['w' => 900]);
    $full = $block->images('images', 'default', ['w' => 1800]); // 라이트박스용 큰 버전(원본 비율)

    // 칼럼: fixed 는 2/3(기본 3, `--N`), flexible 은 auto/2/3(기본 auto, `--cols-N`).
    $colsInput = (string) $block->input('columns');
    if ($isFlex) {
        $cols = in_array($colsInput, ['2', '3'], true) ? $colsInput : 'auto';
        $colClass = "{$base}--cols-{$cols}";
    } else {
        $cols = in_array($colsInput, ['2', '3'], true) ? $colsInput : '3';
        $colClass = "{$base}--{$cols}";
    }
@endphp

@if($block->hasImage('images', 'default'))
    <div class="{{ $base }} {{ $colClass }} {{ $base }}--{{ $ratio }} {{ $base }}--{{ $fit }}">
        @foreach($display as $i => $src)
            <img
                src="{{ $src }}"
                alt="{{ $block->imageAltText('images') }}"
                class="gallery-img"
                loading="lazy"
                data-lightbox-src="{{ $full[$i] ?? $src }}"
                @if($fit === 'fit' && $bg) style="background-color: {{ $bg }}" @endif
            >
        @endforeach
    </div>
    @include('site.partials.lightbox')
@endif
