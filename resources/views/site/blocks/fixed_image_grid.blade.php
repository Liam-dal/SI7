@if($block->hasImage('images', 'default'))
    @php($columns = in_array((string) $block->input('columns'), ['2', '3'], true) ? (int) $block->input('columns') : 3)
    <div style="display:grid;grid-template-columns:repeat({{ $columns }},minmax(0,1fr));gap:1rem;margin:2rem 0;">
        @foreach($block->images('images', 'default') as $image)
            <img src="{{ $image }}" alt="{{ $block->imageAltText('images') }}" style="display:block;width:100%;height:auto;" />
        @endforeach
    </div>
@endif
