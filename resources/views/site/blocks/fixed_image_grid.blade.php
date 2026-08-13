@php
    $columns = in_array((string) $block->input('columns'), ['2', '3'], true) ? (int) $block->input('columns') : 3;
    $ratio = $block->input('ratio');
    $ratio = is_array($ratio) ? ($ratio[0] ?? 'square') : ($ratio ?: 'square');
    if (! in_array($ratio, ['default', 'square', 'landscape', 'portrait'], true)) {
        $ratio = 'square';
    }
    // 기존(크롭 없이 올린) 이미지는 해당 크롭 레코드가 없을 수 있으니 default 로 폴백.
    $crop = $block->hasImage('images', $ratio) ? $ratio : 'default';

    $fit = $block->input('fit_mode') === 'fit' ? 'fit' : 'crop';
    $bg = $block->input('bg_color');

    $display = $block->images('images', $crop, ['w' => 900]);
    $full = $block->images('images', 'default', ['w' => 2000]); // 라이트박스용 큰 버전(원본 비율)
@endphp
@if($block->hasImage('images', 'default'))
    <div class="block-gallery block-gallery--{{ $columns }} block-gallery--{{ $ratio }} block-gallery--{{ $fit }}">
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
