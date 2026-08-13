@php
    $ratio = $block->input('ratio');
    $ratio = is_array($ratio) ? ($ratio[0] ?? 'default') : ($ratio ?: 'default');
    if (! in_array($ratio, ['default', 'square', 'landscape', 'portrait'], true)) {
        $ratio = 'default';
    }
    // 기존(크롭 없이 올린) 이미지는 해당 크롭 레코드가 없을 수 있으니 default 로 폴백.
    $crop = ($ratio !== 'default' && $block->hasImage('images', $ratio)) ? $ratio : 'default';

    $columns = in_array((string) $block->input('columns'), ['2', '3'], true) ? (int) $block->input('columns') : 'auto';

    $fit = $block->input('fit_mode') === 'fit' ? 'fit' : 'crop';
    $bg = $block->input('bg_color');

    // Fit: 원본(비크롭)을 박스에 contain → 세로 긴 것도 전체가 보이고 여백은 배경색.
    // Crop: 비율 크롭으로 박스를 꽉 채움.
    $imgCrop = $fit === 'fit' ? 'default' : $crop;
    $display = $block->images('images', $imgCrop, ['w' => 900]);
    $full = $block->images('images', 'default', ['w' => 2560]); // 라이트박스용 큰 버전(원본 비율)
@endphp
@if($block->hasImage('images', 'default'))
    <div class="block-flex-gallery block-flex-gallery--{{ $ratio }} block-flex-gallery--cols-{{ $columns }} block-flex-gallery--{{ $fit }}">
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
