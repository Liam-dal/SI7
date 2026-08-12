@props(['media' => null, 'role' => 'cover', 'ratio' => 'wide', 'alt' => null, 'eager' => false, 'sizes' => '100vw', 'placeholder' => 'IMAGE'])

@php
    $widths = $ratio === 'banner' ? [768, 1200, 1920, 2400] : [480, 768, 1200, 1920];
    $crop = in_array($ratio, ['wide', 'banner'], true) ? 'wide' : 'default';
    $image = $media?->hasImage($role) ? $media->imageAsArray($role, $crop, ['w' => end($widths)]) : null;
    if (empty($image) && $crop !== 'default') {
        $crop = 'default';
        $image = $media?->imageAsArray($role, $crop, ['w' => end($widths)]);
    }
    $altText = $alt ?? ($image['alt'] ?? '');
@endphp

<span {{ $attributes->class(['media', 'media--' . $ratio]) }}>
    @if(!empty($image))
        <img
            src="{{ $image['src'] }}"
            srcset="{{ collect($widths)->map(fn ($width) => $media->image($role, $crop, ['w' => $width]) . ' ' . $width . 'w')->implode(', ') }}"
            sizes="{{ $sizes }}"
            width="{{ $image['width'] }}"
            height="{{ $image['height'] }}"
            alt="{{ $altText }}"
            loading="{{ $eager ? 'eager' : 'lazy' }}"
            decoding="async"
            @if($eager) fetchpriority="high" @endif
        >
    @else
        <span class="media__blank">{{ $placeholder }}</span>
    @endif
</span>
