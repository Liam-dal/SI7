<section class="block-text">
    @if($block->translatedInput('title'))
        <h3>
            {{ $block->translatedInput('title') }}
        </h3>
    @endif
    {!! $block->translatedInput('text') !!}
</section>
