@php
    $ratio = $block->input('ratio');
    $ratio = is_array($ratio) ? ($ratio[0] ?? 'default') : ($ratio ?: 'default');
    if (! in_array($ratio, ['default', 'square', 'landscape', 'portrait'], true)) {
        $ratio = 'default';
    }
    // 기존(크롭 없이 올린) 이미지는 해당 크롭 레코드가 없을 수 있으니 default 로 폴백.
    $crop = ($ratio !== 'default' && $block->hasImage('images', $ratio)) ? $ratio : 'default';
@endphp
@if($block->hasImage('images', 'default'))
    <div class="block-flex-gallery block-flex-gallery--{{ $ratio }}">
        @foreach($block->images('images', $crop, ['w' => 900]) as $image)
            <img src="{{ $image }}" alt="{{ $block->imageAltText('images') }}" loading="lazy">
        @endforeach
    </div>
@endif
