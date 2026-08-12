<blockquote class="block-quote">
    {!! $block->input('quote') !!}
    @if($block->input('attribution'))
        <footer>— {{ $block->input('attribution') }}</footer>
    @endif
</blockquote>
