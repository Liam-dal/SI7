{{-- 자동재생 영상(data-video-viewport)은 화면 안에 있을 때만 재생한다 (스크롤 성능·배터리).
     영상 블록과 Guide 커버 영상이 함께 쓰므로 @once 로 한 번만 출력. --}}
@once
@push('scripts')
<script>
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
