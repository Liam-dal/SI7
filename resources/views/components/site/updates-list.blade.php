@props(['items'])

@php $items = collect($items); @endphp

<div class="updates-list" data-updates-list>
    <ul class="updates-list__rows">
        @foreach($items as $item)
            <li class="updates-list__row">
                <a class="updates-list__link" href="{{ $item['href'] ?? '#' }}">
                    <span class="updates-list__category">{{ $item['category'] ?? '' }}</span>
                    <span class="updates-list__title">{{ $item['title'] ?? '' }}</span>
                    <span class="updates-list__arrow" aria-hidden="true">→</span>
                    <span class="updates-list__more" aria-hidden="true">Read full article <span class="updates-list__more-icon">↗</span></span>

                    <span class="updates-list__cover">
                        @if(!empty($item['cover']))
                            <x-site.image :media="$item['cover']" role="cover" ratio="square" sizes="120px" :alt="$item['title'] ?? ''" />
                        @endif
                    </span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
