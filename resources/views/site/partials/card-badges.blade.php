{{-- 프로젝트 카드 뱃지를 첫 줄에 들어가는 만큼만 남기고 나머지는 +N 으로 접는다.
     몇 개가 들어가는지는 카드 폭과 글자 폭에 달려 있어 서버에서 계산할 수 없다.
     카드가 여러 개여도 스크립트는 @once 로 한 번만 나간다. --}}
@once
@push('scripts')
<script>
(() => {
    const fit = (box) => {
        const chips = [...box.querySelectorAll('.card__badge')].filter((c) => !c.hasAttribute('data-badge-more'));
        const more = box.querySelector('[data-badge-more]');
        if (!chips.length || !more) return;

        // 매번 전부 펼친 상태에서 다시 잰다(리사이즈로 넓어졌을 수 있다).
        chips.forEach((chip) => { chip.hidden = false; });
        more.hidden = true;

        const firstLineTop = chips[0].offsetTop;
        let visible = chips.filter((chip) => chip.offsetTop === firstLineTop).length;

        if (visible === chips.length) return; // 전부 한 줄에 들어감

        // +N 칩도 자리를 차지하므로, 그 칩까지 첫 줄에 앉을 때까지 뒤에서 하나씩 줄인다.
        more.hidden = false;
        while (visible > 0) {
            chips.forEach((chip, i) => { chip.hidden = i >= visible; });
            more.textContent = '+' + (chips.length - visible);
            if (more.offsetTop === firstLineTop) break;
            visible -= 1;
        }
    };

    const fitAll = () => document.querySelectorAll('[data-card-badges]').forEach(fit);

    fitAll();
    // 웹폰트가 늦게 붙으면 글자 폭이 달라져 몇 개가 들어가는지도 바뀐다.
    document.fonts?.ready.then(fitAll);

    let queued = false;
    window.addEventListener('resize', () => {
        if (queued) return;
        queued = true;
        requestAnimationFrame(() => { queued = false; fitAll(); });
    }, { passive: true });
})();
</script>
@endpush
@endonce
