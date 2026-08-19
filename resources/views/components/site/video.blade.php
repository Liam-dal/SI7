@props([
    'url' => null,
    'file' => null,
    'poster' => null,
    'autoplay' => false,
    'loop' => false,
    'controls' => true,
    'title' => 'Video',
])

@php
    $embed = null;
    $u = trim((string) $url);
    $f = trim((string) $file);

    // 업로드 파일이 있으면 그것을 우선한다. 없을 때만 외부 임베드를 시도.
    if ($f === '' && $u !== '') {
        // YouTube (youtu.be, watch?v=, embed/, shorts/)
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|v/|shorts/))([A-Za-z0-9_-]{6,})~', $u, $m)) {
            $id = $m[1];
            $p = ['rel' => 0, 'modestbranding' => 1, 'playsinline' => 1];
            if ($autoplay) { $p['autoplay'] = 1; $p['mute'] = 1; }
            if ($loop) { $p['loop'] = 1; $p['playlist'] = $id; }
            if (! $controls) { $p['controls'] = 0; }
            $embed = 'https://www.youtube.com/embed/' . $id . '?' . http_build_query($p);
        }
        // Vimeo
        elseif (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $u, $m)) {
            $id = $m[1];
            $p = [];
            if ($autoplay) { $p['autoplay'] = 1; $p['muted'] = 1; }
            if ($loop) { $p['loop'] = 1; }
            if (! $controls) { $p['controls'] = 0; }
            $embed = 'https://player.vimeo.com/video/' . $id . ($p ? '?' . http_build_query($p) : '');
        }
    }
@endphp

@if($f !== '')
    <div {{ $attributes->class('video-file') }}>
        <video
            class="video-file__el"
            src="{{ $f }}"
            @if($poster) poster="{{ $poster }}" @endif
            @if($controls) controls @endif
            @if($autoplay) autoplay muted data-video-viewport @endif
            @if($loop) loop @endif
            playsinline
            preload="{{ $autoplay ? 'auto' : 'metadata' }}"
            title="{{ $title }}"
        ></video>
    </div>
@elseif($embed)
    <div {{ $attributes->class('video-embed') }}>
        <iframe
            src="{{ $embed }}"
            title="{{ $title }}"
            frameborder="0"
            allow="autoplay; fullscreen; picture-in-picture; encrypted-media"
            allowfullscreen
            loading="lazy"
        ></iframe>
    </div>
@endif
