@props(['title' => null, 'description' => null, 'kicker' => null, 'layout' => 'split'])

@php
    // Wysiwyg fields save a cleared value as markup ("<p></p>"), which is truthy but renders
    // blank — judge emptiness by the text that survives strip_tags, not the raw value.
    $lead = trim(strip_tags((string) $description));
    $layout = in_array($layout, ['stack', 'split'], true) ? $layout : 'split';
@endphp

<header {{ $attributes->class(['page-head', 'page-head--' . $layout]) }}>
    <div class="page-head__primary">
        @if($kicker)<p class="page-head__kicker">{{ $kicker }}</p>@endif
        @if($title)<h1 class="page-head__title">{!! nl2br(e($title)) !!}</h1>@endif
    </div>
    @if($lead !== '')<p class="page-head__lead">{{ $lead }}</p>@endif
</header>
