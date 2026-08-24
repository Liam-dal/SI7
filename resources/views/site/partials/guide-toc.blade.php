{{-- 가이드 상세의 떠 있는 섹션 인디케이터.
     섹션 제목은 블록(heading_description)과 본문 에디터 양쪽에서 h2 로 렌더링되므로,
     서버에서 HTML 을 파싱하지 않고 렌더된 문서에서 직접 수집한다(점진적 향상 —
     JS 가 없으면 그냥 나타나지 않고 본문은 그대로 읽힌다). --}}
<nav class="guide-toc" aria-label="섹션 목차" hidden></nav>

@push('scripts')
<script>
(() => {
    const nav = document.querySelector('.guide-toc');
    const body = document.querySelector('.guide-article__body');
    if (!nav || !body) return;

    // 제목이 비어 있는 블록(heading 을 안 채운 heading_description)은 건너뛴다.
    const headings = [...body.querySelectorAll('h2')].filter((h) => h.textContent.trim() !== '');
    if (headings.length < 2) return; // 한 섹션짜리 글에는 띄울 이유가 없다

    const items = headings.map((heading, i) => {
        // 한글 제목은 슬러그가 비어버리므로 순번으로 id 를 만든다.
        if (!heading.id) heading.id = 'guide-section-' + (i + 1);

        const label = heading.textContent.trim();
        const link = document.createElement('a');
        link.className = 'guide-toc__item';
        link.href = '#' + heading.id;
        link.setAttribute('aria-label', label);
        link.innerHTML = '<span class="guide-toc__label" aria-hidden="true"></span><span class="guide-toc__line"></span>';
        link.querySelector('.guide-toc__label').textContent = label;

        // 헤더가 제목을 가리지 않도록 scroll-margin-top 을 쓰는 부드러운 이동.
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            heading.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'start' });
            history.replaceState(null, '', '#' + heading.id);
        });

        nav.appendChild(link);

        return link;
    });

    nav.hidden = false;

    // 현재 섹션 = 화면 위쪽 30% 선을 마지막으로 지나간 제목.
    let ticking = false;
    const sync = () => {
        const line = window.scrollY + window.innerHeight * 0.3;
        let active = 0;
        headings.forEach((heading, i) => {
            if (heading.getBoundingClientRect().top + window.scrollY <= line) active = i;
        });
        items.forEach((item, i) => item.classList.toggle('is-active', i === active));
        ticking = false;
    };

    const onScroll = () => {
        if (!ticking) { ticking = true; requestAnimationFrame(sync); }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    sync();
})();
</script>
@endpush
