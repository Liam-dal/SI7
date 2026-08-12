<span class="dh-field" data-dh-field data-dh-key="{{ $key }}" data-default="{{ $default ?? '' }}">
    <button class="dh-field__btn" type="button" aria-haspopup="listbox" aria-expanded="false" aria-label="{{ $srLabel ?? '선택' }}" data-dh-toggle>
        <span class="dh-field__viewport">
            <span class="dh-field__roll" data-dh-roll>
                @foreach($options as $opt)
                    <span class="dh-field__item" data-value="{{ $opt['value'] }}">{{ $opt['label'] }}</span>
                @endforeach
            </span>
        </span>
        <span class="dh-field__caret" aria-hidden="true"></span>
    </button>
    <ul class="dh-field__list" role="listbox" data-dh-list hidden>
        @foreach($options as $opt)
            <li class="dh-field__option" role="option" data-value="{{ $opt['value'] }}">{{ $opt['label'] }}</li>
        @endforeach
    </ul>
</span>
