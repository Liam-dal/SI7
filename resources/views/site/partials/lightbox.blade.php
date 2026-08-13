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
    function close() { lb.hidden = true; img.removeAttribute('src'); }
    document.addEventListener('click', function (e) {
        var trigger = e.target.closest('[data-lightbox-src]');
        if (trigger) {
            img.src = trigger.getAttribute('data-lightbox-src');
            lb.hidden = false;
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
