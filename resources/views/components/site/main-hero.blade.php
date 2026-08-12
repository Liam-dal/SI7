@props(['eyebrow' => null, 'title', 'description' => null])

<header {{ $attributes->class('main-hero') }}>
    @if($eyebrow)
        <p class="main-hero__eyebrow">{{ $eyebrow }}</p>
    @endif
    <h1 class="main-hero__title">{!! nl2br(e($title)) !!}</h1>
    @if($description)
        <div class="main-hero__description">{!! $description !!}</div>
    @endif
</header>
