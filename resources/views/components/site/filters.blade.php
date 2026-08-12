@props(['items', 'selected' => null, 'allLabel' => 'All projects', 'label' => '프로젝트 카테고리'])

<nav {{ $attributes->class('filters') }} aria-label="{{ $label }}">
    <a href="{{ route('projects') }}" data-category-filter data-category-id="" @class(['is-active' => !$selected])>{{ $allLabel }}</a>
    @foreach($items as $item)
        <a href="{{ route('projects', ['category' => $item->id]) }}" data-category-filter data-category-id="{{ $item->id }}" @class(['is-active' => $selected === $item->id])>{{ $item->title }}</a>
    @endforeach
</nav>
