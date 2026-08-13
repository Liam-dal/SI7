{{-- 클릭 시 큰 이미지 보기. 여러 갤러리에 include 돼도 @once 로 한 번만 출력. --}}
@once
@push('scripts')
<div class="lightbox" id="site-lightbox" hidden>
    <button class="lightbox__close" type="button" aria-label="닫기">&times;</button>
    <img src="" alt="">
</div>
<script>
(function () {
    var lb = document.getElementById('site-lightbox');
    if (!lb) return;
    var img = lb.querySelector('img');
    function close() { lb.hidden = true; lb.classList.remove('is-zoomed'); img.removeAttribute('src'); document.documentElement.classList.remove('lightbox-open'); }
    document.addEventListener('click', function (e) {
        var trigger = e.target.closest('[data-lightbox-src]');
        if (trigger) {
            var small = trigger.currentSrc || trigger.getAttribute('src');
            var full = trigger.getAttribute('data-lightbox-src');
            // 이미 로드된 작은 이미지를 즉시 표시 → 빈 화면 없이 바로 열림.
            img.src = small || full;
            lb.classList.remove('is-zoomed', 'is-loading');
            lb.hidden = false;
            document.documentElement.classList.add('lightbox-open');
            // 큰 버전은 뒤에서 받아 준비되면 교체(선명해짐).
            if (full && full !== small) {
                lb.classList.add('is-loading');
                var pre = new Image();
                pre.onload = function () {
                    if (!lb.hidden && img.src.indexOf(small) !== -1) { img.src = full; }
                    lb.classList.remove('is-loading');
                };
                pre.onerror = function () { lb.classList.remove('is-loading'); };
                pre.src = full;
            }
            return;
        }
        // 라이트박스 이미지를 클릭하면 원본 크기로 한 번 더 확대(토글).
        if (e.target === img) {
            lb.classList.toggle('is-zoomed');
            if (lb.classList.contains('is-zoomed')) { lb.scrollTop = 0; lb.scrollLeft = 0; }
            return;
        }
        if (e.target === lb || e.target.classList.contains('lightbox__close')) {
            close();
        }
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !lb.hidden) close();
    });
})();
</script>
@endpush
@endonce
