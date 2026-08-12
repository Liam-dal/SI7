@if($block->hasImage('images', 'default'))
    @php($columns = in_array((string) $block->input('columns'), ['2', '3'], true) ? (int) $block->input('columns') : 3)
    <div class="block-gallery block-gallery--{{ $columns }}">
        @foreach($block->images('images', 'default') as $image)
            <img src="{{ $image }}" alt="{{ $block->imageAltText('images') }}" loading="lazy">
        @endforeach
    </div>
@endif
