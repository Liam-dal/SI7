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
    label="Alignment"
    default="left"
    :options="[
        ['value' => 'left', 'label' => 'Left'],
        ['value' => 'right', 'label' => 'Right'],
    ]"
    note="Places the quote in the left or right column of a two-column layout."
/>
