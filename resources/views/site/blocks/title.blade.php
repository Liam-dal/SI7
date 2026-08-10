<section style="margin: 3rem 0 1.25rem;">
    @if($block->input('eyebrow'))
        <p style="margin: 0 0 .5rem; color: #6b7280; font-size: .8rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;">
            {{ $block->input('eyebrow') }}
        </p>
    @endif
    <h2 style="margin: 0; font-size: 2rem; line-height: 1.2;">
        {{ $block->input('heading') }}
    </h2>
</section>
