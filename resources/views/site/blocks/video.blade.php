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

    @once
    @push('scripts')
    <script>
    // 자동재생 데모 영상은 화면 안에 있을 때만 재생한다 (스크롤 성능·배터리).
    (() => {
        const nodes = document.querySelectorAll('video[data-video-viewport]');
        if (!nodes.length || !('IntersectionObserver' in window)) return;

        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                const v = entry.target;
                if (entry.isIntersecting) {
                    v.play().catch(() => {});
                } else if (!v.paused) {
                    v.pause();
                }
            });
        }, { threshold: 0.15 });

        nodes.forEach((v) => io.observe(v));
    })();
    </script>
    @endpush
    @endonce
@endif
