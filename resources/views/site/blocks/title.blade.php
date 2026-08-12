<section class="block-title">
    @if($block->input('eyebrow'))
        <p class="block-title__eyebrow">
            {{ $block->input('eyebrow') }}
        </p>
    @endif
    <h2>
        {{ $block->input('heading') }}
    </h2>
</section>
