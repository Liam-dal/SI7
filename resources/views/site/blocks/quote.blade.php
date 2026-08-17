@php
    $align = $block->input('align') === 'right' ? 'right' : 'left';
@endphp
<blockquote class="block-quote block-quote--{{ $align }}">
    {!! $blockValue($block, 'quote') !!}
    @if($blockValue($block, 'attribution'))
        <footer>— {{ $blockValue($block, 'attribution') }}</footer>
    @endif
</blockquote>
