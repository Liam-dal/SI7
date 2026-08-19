@twillBlockTitle('Quote')
@twillBlockIcon('text')
@twillBlockGroup('Content')

<x-twill::wysiwyg
    name="quote"
    label="Quote"
    :translated="true"
    :toolbar-options="['bold', 'italic', 'link', 'clean']"
/>
<x-twill::input name="attribution" label="Attribution (optional)" :translated="true" />

<x-twill::select
    name="align"
    label="위치"
    default="left"
    :options="[
        ['value' => 'left', 'label' => '왼쪽'],
        ['value' => 'right', 'label' => '오른쪽'],
    ]"
    note="2칼럼 기준으로 왼쪽/오른쪽에 배치합니다."
/>
