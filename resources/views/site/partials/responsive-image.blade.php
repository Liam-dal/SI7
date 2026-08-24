@php
    $crop = $crop ?? 'default';
    $widths = $widths ?? [640, 960, 1440, 1920, 2560];
    $sizes = $sizes ?? '100vw';
    $image = $model->imageAsArray($role, $crop, ['w' => end($widths)]);
    // 기존에 업로드된 이미지는 새 크롭 레코드가 없을 수 있으므로,
    // 새 크롭을 편집하기 전까지 기존 default 크롭을 안전하게 사용합니다.
    if (empty($image) && $crop !== 'default') {
        $crop = 'default';
        $image = $model->imageAsArray($role, $crop, ['w' => end($widths)]);
    }
@endphp
@if(!empty($image))
    <img
        class="{{ $class ?? '' }}"
        src="{{ $image['src'] }}"
        srcset="{{ collect($widths)->map(fn ($width) => $model->image($role, $crop, ['w' => $width]) . ' ' . $width . 'w')->implode(', ') }}"
        sizes="{{ $sizes }}"
        width="{{ $image['width'] }}"
        height="{{ $image['height'] }}"
        alt="{{ $image['alt'] ?? '' }}"
        loading="{{ $loading ?? 'lazy' }}"
        decoding="async"
    >
@endif
