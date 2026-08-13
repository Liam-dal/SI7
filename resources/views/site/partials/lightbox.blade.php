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
            img.src = trigger.getAttribute('data-lightbox-src');
            lb.classList.remove('is-zoomed');
            lb.hidden = false;
            document.documentElement.classList.add('lightbox-open');
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
