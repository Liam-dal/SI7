@props(['url' => null, 'autoplay' => false, 'loop' => false, 'title' => 'Video'])

@php
    $embed = null;
    $u = trim((string) $url);
    if ($u !== '') {
        // YouTube (youtu.be, watch?v=, embed/, shorts/)
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|v/|shorts/))([A-Za-z0-9_-]{6,})~', $u, $m)) {
            $id = $m[1];
            $p = ['rel' => 0, 'modestbranding' => 1, 'playsinline' => 1];
            if ($autoplay) { $p['autoplay'] = 1; $p['mute'] = 1; }
            if ($loop) { $p['loop'] = 1; $p['playlist'] = $id; }
            $embed = 'https://www.youtube.com/embed/' . $id . '?' . http_build_query($p);
        }
        // Vimeo
        elseif (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $u, $m)) {
            $id = $m[1];
            $p = [];
            if ($autoplay) { $p['autoplay'] = 1; $p['muted'] = 1; }
            if ($loop) { $p['loop'] = 1; }
            $embed = 'https://player.vimeo.com/video/' . $id . ($p ? '?' . http_build_query($p) : '');
        }
    }
@endphp

@if($embed)
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
