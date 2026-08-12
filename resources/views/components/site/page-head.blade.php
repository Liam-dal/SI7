@props(['title', 'description' => null, 'kicker' => null, 'align' => 'stack'])

<header {{ $attributes->class(['page-head', 'page-head--' . $align]) }}>
    @if($align === 'split')
        <div>
            @if($kicker)<p class="page-head__kicker">{{ $kicker }}</p>@endif
            <h1 class="page-head__title">{{ $title }}</h1>
        </div>
        @if($description)<p class="page-head__summary">{{ strip_tags($description) }}</p>@endif
    @elseif($align === 'muted')
        <h1 class="page-head__title page-head__title--muted">{{ $title }}</h1>
        @if($description)<h2 class="page-head__title page-head__description">{{ strip_tags($description) }}</h2>@endif
    @else
        <div class="page-head__primary">
            @if($kicker)<p class="page-head__kicker">{{ $kicker }}</p>@endif
            <h1 class="page-head__title">{{ $title }}</h1>
        </div>
        @if($description)<p class="page-head__lead">{{ strip_tags($description) }}</p>@endif
    @endif
</header>
