@props(['data'])

@php
    $categories = $data['categories'];
    $sectors = $data['sectors'];
    $projects = $data['projects'];
    $defCat = $data['defaultCategoryId'] ?? null;
    $defSec = $data['defaultSectorId'] ?? null;

    $catOptions = collect([['value' => '', 'label' => 'everything']])
        ->concat($categories->map(fn ($c) => ['value' => (string) $c->id, 'label' => $c->title]));
    $secOptions = collect([['value' => '', 'label' => 'everyone']])
        ->concat($sectors->map(fn ($s) => ['value' => (string) $s->id, 'label' => $s->title]));
@endphp

<section class="design-hero" data-design-hero>
    <div class="design-hero__media" aria-hidden="true">
        @foreach($projects as $project)
            <a class="design-hero__slide"
               href="{{ route('projects.show', $project->slug ?: $project->id) }}"
               data-slide
               data-cats="{{ $project->categories->pluck('id')->implode(',') }}"
               data-sectors="{{ $project->sectors->pluck('id')->implode(',') }}"
               tabindex="-1">
                <x-site.image :media="$project" role="cover" ratio="wide" :eager="$loop->first" sizes="100vw" :alt="$project->title" />
                <span class="design-hero__caption">
                    <span class="design-hero__caption-title">{{ $project->title }}</span>
                    @if($project->subtitle)
                        <span class="design-hero__caption-sub">{{ $project->subtitle }}</span>
                    @endif
                </span>
            </a>
        @endforeach
    </div>

    <div class="design-hero__inner">
        <h1 class="design-hero__sentence">
            <span class="dh-static">We design</span>
            @include('site.partials.design-field', ['key' => 'category', 'options' => $catOptions, 'default' => $defCat, 'srLabel' => 'Discipline'])
            <span class="dh-static">for</span>
            @include('site.partials.design-field', ['key' => 'sector', 'options' => $secOptions, 'default' => $defSec, 'srLabel' => 'Sector'])
        </h1>

        <p class="design-hero__empty" data-hero-empty hidden>선택한 조합에 해당하는 프로젝트가 아직 없어요.</p>
    </div>

    <div class="design-hero__dots" data-hero-dots></div>
</section>

@push('scripts')
<script>
(() => {
    const hero = document.querySelector('[data-design-hero]');
    if (!hero) return;

    const slides = Array.from(hero.querySelectorAll('[data-slide]'));
    const dotsWrap = hero.querySelector('[data-hero-dots]');
    const empty = hero.querySelector('[data-hero-empty]');
    const fieldEls = Array.from(hero.querySelectorAll('[data-dh-field]'));
    const state = {};

    const setField = (key, index, animate) => {
        const f = state[key];
        f.index = (index + f.items.length) % f.items.length;
        const item = f.items[f.index];
        if (!animate) { f.viewport.style.transition = 'none'; f.roll.style.transition = 'none'; }
        f.viewport.style.width = item.offsetWidth + 'px';
        f.roll.style.transform = 'translateY(' + (-item.offsetTop) + 'px)';
        if (!animate) { void f.roll.offsetWidth; f.viewport.style.transition = ''; f.roll.style.transition = ''; }
        f.items.forEach((it, i) => it.classList.toggle('is-current', i === f.index));
        f.options.forEach((op, i) => op.classList.toggle('is-current', i === f.index));
    };
    const valueOf = (key) => state[key].items[state[key].index].dataset.value;

    const closeLists = () => fieldEls.forEach(fe => {
        fe.querySelector('[data-dh-list]').hidden = true;
        fe.querySelector('[data-dh-toggle]').setAttribute('aria-expanded', 'false');
        fe.classList.remove('is-open');
    });

    // ---- Slideshow ----
    let visible = [], sIdx = 0, sTimer = null;
    const matches = (sl) => {
        const c = valueOf('category'), s = valueOf('sector');
        const cats = (sl.dataset.cats || '').split(',').filter(Boolean);
        const secs = (sl.dataset.sectors || '').split(',').filter(Boolean);
        return (!c || cats.includes(c)) && (!s || secs.includes(s));
    };
    const renderSlides = () => {
        slides.forEach(sl => sl.classList.remove('is-active'));
        if (visible.length) visible[sIdx % visible.length].classList.add('is-active');
        dotsWrap.innerHTML = visible.map((_, i) =>
            '<button type="button" class="design-hero__dot' + (i === sIdx % visible.length ? ' is-on' : '') + '" data-dot="' + i + '" aria-label="' + (i + 1) + '"></button>'
        ).join('');
    };
    const stopSlides = () => { if (sTimer) { clearInterval(sTimer); sTimer = null; } };
    const startSlides = () => { stopSlides(); if (visible.length > 1) sTimer = setInterval(() => { sIdx = (sIdx + 1) % visible.length; renderSlides(); }, 4500); };
    const applyFilter = () => {
        visible = slides.filter(matches);
        sIdx = 0;
        hero.classList.toggle('is-empty', visible.length === 0);
        if (empty) empty.hidden = visible.length !== 0;
        renderSlides(); startSlides();
    };
    dotsWrap.addEventListener('click', (e) => { const b = e.target.closest('[data-dot]'); if (!b) return; sIdx = Number(b.dataset.dot); renderSlides(); startSlides(); });

    // ---- Autoplay slot roll (idle attract) — rolls the Discipline text like a slot machine.
    // 순수 연출: 배경 슬라이드쇼는 그대로 부드럽게 재생되고, 사용자가 직접 선택하면 그때 필터링됩니다.
    const ROLL_INTERVAL_MS = 1500; // 슬롯 롤 속도 (작을수록 빠름)
    let auto = null;
    const stopAuto = () => { if (auto) { clearInterval(auto); auto = null; } };
    const startAuto = () => {
        const items = state['category'].items;
        const idxs = items.map((_, i) => i).filter(i => i !== 0); // "everything" 제외, 실제 Discipline만 롤
        if (idxs.length < 2) return;
        let p = Math.max(0, idxs.indexOf(state['category'].index));
        auto = setInterval(() => {
            p = (p + 1) % idxs.length;
            setField('category', idxs[p], true);
        }, ROLL_INTERVAL_MS);
    };

    // ---- Init fields ----
    fieldEls.forEach(fe => {
        const key = fe.dataset.dhKey;
        state[key] = {
            el: fe,
            roll: fe.querySelector('[data-dh-roll]'),
            viewport: fe.querySelector('.dh-field__viewport'),
            items: Array.from(fe.querySelectorAll('.dh-field__item')),
            options: Array.from(fe.querySelectorAll('.dh-field__option')),
            btn: fe.querySelector('[data-dh-toggle]'),
            list: fe.querySelector('[data-dh-list]'),
            index: 0,
        };
        const def = fe.dataset.default || '';
        let di = state[key].items.findIndex(it => it.dataset.value === def);
        if (di < 0) di = 0;
        setField(key, di, false);

        state[key].btn.addEventListener('click', (e) => {
            e.stopPropagation();
            stopAuto();
            const willOpen = state[key].list.hidden;
            closeLists();
            if (willOpen) { state[key].list.hidden = false; state[key].btn.setAttribute('aria-expanded', 'true'); fe.classList.add('is-open'); }
        });
        state[key].list.addEventListener('click', (e) => {
            const op = e.target.closest('[data-value]');
            if (!op) return;
            stopAuto();
            const i = state[key].items.findIndex(it => it.dataset.value === op.dataset.value);
            setField(key, i, true);
            closeLists();
            applyFilter();
        });
    });

    document.addEventListener('click', closeLists);
    window.addEventListener('resize', () => { Object.keys(state).forEach(k => setField(k, state[k].index, false)); });

    applyFilter();
    if (valueOf('category') === '' && valueOf('sector') === '') startAuto();
})();
</script>
@endpush
