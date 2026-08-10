<section style="margin: 1.5rem 0; line-height: 1.75;">
    @if($block->translatedInput('title'))
        <h3 style="margin: 0 0 .75rem; font-size: 1.25rem;">
            {{ $block->translatedInput('title') }}
        </h3>
    @endif
    {!! $block->translatedInput('text') !!}
</section>
