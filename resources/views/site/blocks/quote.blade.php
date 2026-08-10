<blockquote style="margin:2rem 0;font-size:1.5rem;line-height:1.3;">
    {!! $block->input('quote') !!}
    @if($block->input('attribution'))
        <footer style="margin-top:.75rem;font-size:1rem;">— {{ $block->input('attribution') }}</footer>
    @endif
</blockquote>
