@php
    $file = $block->file('video');
    $url = $block->input('url');

    $mode = $block->input('mode');
    $mode = is_array($mode) ? ($mode[0] ?? 'controls') : ($mode ?: 'controls');
    $isDemo = $mode === 'demo';

    $width = $block->input('width');
    $width = is_array($width) ? ($width[0] ?? 'full') : ($width ?: 'full');

    $poster = $block->hasImage('poster', 'default') ? $block->image('poster', 'default') : null;
    $caption = $blockValue($block, 'caption');
@endphp

@if($file || trim((string) $url) !== '')
    <figure class="block-video block-video--{{ $width }}">
        <x-site.video
            :file="$file"
            :url="$url"
            :poster="$poster"
            :autoplay="$isDemo"
            :loop="$isDemo"
            :controls="! $isDemo"
            :title="$caption ?: 'Project video'"
        />
        @if($caption)
            <figcaption>{{ $caption }}</figcaption>
        @endif
    </figure>

    @include('site.partials.video-viewport')
@endif
