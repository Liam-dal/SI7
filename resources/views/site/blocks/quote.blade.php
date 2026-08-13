<blockquote class="block-quote">
    {!! $block->translatedInput('quote') !!}
    @if($block->translatedInput('attribution'))
        <footer>— {{ $block->translatedInput('attribution') }}</footer>
    @endif
</blockquote>
