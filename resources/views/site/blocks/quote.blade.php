<blockquote class="block-quote">
    {!! $blockValue($block, 'quote') !!}
    @if($blockValue($block, 'attribution'))
        <footer>— {{ $blockValue($block, 'attribution') }}</footer>
    @endif
</blockquote>
