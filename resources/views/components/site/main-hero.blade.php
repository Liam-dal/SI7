@props(['eyebrow' => null, 'title' => null, 'description' => null])

<header {{ $attributes->class('main-hero') }}>
    @if($eyebrow)
        <p class="main-hero__eyebrow">{{ $eyebrow }}</p>
    @endif
    @if($title)
        <h1 class="main-hero__title">{!! nl2br(e($title)) !!}</h1>
    @endif
    @if($description)
        <div class="main-hero__description">{!! $description !!}</div>
    @endif
</header>
