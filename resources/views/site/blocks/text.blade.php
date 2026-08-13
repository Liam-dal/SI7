<section class="block-text">
    @if($blockValue($block, 'title'))
        <h3>
            {{ $blockValue($block, 'title') }}
        </h3>
    @endif
    {!! $blockValue($block, 'text') !!}
</section>
