@if($block->hasImage('images', 'default'))
    <div style="display:flex;flex-wrap:wrap;align-items:flex-start;gap:1rem;margin:2rem 0;">
        @foreach($block->images('images', 'default') as $image)
            <img src="{{ $image }}" alt="{{ $block->imageAltText('images') }}" style="display:block;flex:1 1 280px;max-width:100%;height:auto;" />
        @endforeach
    </div>
@endif
